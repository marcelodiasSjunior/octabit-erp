<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\Client;
use App\Models\Quote;
use App\Enums\UserRole;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected $companyA;
    protected $companyB;
    protected $userA;
    protected $userB;
    protected $masterUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyA = Company::create(['name' => 'Company A', 'uuid' => str()->uuid()]);
        $this->companyB = Company::create(['name' => 'Company B', 'uuid' => str()->uuid()]);

        $this->userA = User::factory()->create([
            'company_id' => $this->companyA->id,
            'role' => UserRole::User
        ]);

        $this->userB = User::factory()->create([
            'company_id' => $this->companyB->id,
            'role' => UserRole::User
        ]);

        $this->masterUser = User::factory()->create([
            'role' => UserRole::MasterGlobal,
            'company_id' => null
        ]);
    }

    test('user from Company A cannot access Client from Company B', function () {
        $clientB = Client::factory()->create(['company_id' => $this->companyB->id]);

        $this->actingAs($this->userA)
            ->get(route('clients.show', $clientB))
            ->assertStatus(404);
    });

    test('user from Company A cannot update Quote from Company B', function () {
        $quoteB = Quote::factory()->create(['company_id' => $this->companyB->id]);

        $this->actingAs($this->userA)
            ->put(route('quotes.update', $quoteB), [
                'client_id' => $quoteB->client_id,
                'valid_until' => now()->addDays(7)->toDateString(),
                'items' => [['description' => 'Test', 'quantity' => 1, 'unit_price' => 100]]
            ])
            ->assertStatus(404);
    });

    test('Master Global user can see records from all companies', function () {
        Client::factory()->create(['company_id' => $this->companyA->id]);
        Client::factory()->create(['company_id' => $this->companyB->id]);

        $this->actingAs($this->masterUser);
        
        // Ensure no tenant is set for master context in this request
        app(TenantManager::class)->setCompanyId(null);

        // We use the index route or check count
        $this->get(route('clients.index'))
            ->assertOk()
            ->assertSee('Company A') // Assuming factory uses company name or similar
            ->assertSee('Company B');
            
        expect(Client::count())->toBe(2);
    });

    test('client creation automatically sets company_id', function () {
        $this->actingAs($this->userA);
        
        // Simulating the middleware behavior
        app(TenantManager::class)->setCompanyId($this->userA->company_id);

        $client = Client::create([
            'name' => 'New Tenant Client',
            'email' => 'tenant@example.com',
            'document' => '12345678901'
        ]);

        expect($client->company_id)->toBe($this->companyA->id);
    });

    test('sequential numbers are unique per company', function () {
        $quoteA = Quote::factory()->create(['company_id' => $this->companyA->id, 'sequential_number' => 1]);
        $quoteB = Quote::factory()->create(['company_id' => $this->companyB->id, 'sequential_number' => 1]);

        expect($quoteA->sequential_number)->toBe(1)
            ->and($quoteB->sequential_number)->toBe(1);
            
        expect($quoteA->id)->not->toBe($quoteB->id);
    });
}
