<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LeadWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_creates_new_lead(): void
    {
        $payload = [
            'nome' => 'John Doe',
            'email' => 'john@example.com',
            'telefone' => '11999999999',
            'mensagem' => 'Hello World',
            'origem' => 'landing-page'
        ];

        $response = $this->postJson('/api/webhooks/leads', $payload);

        $response->assertStatus(201)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('clients', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '11999999999'
        ]);

        $client = Client::where('email', 'john@example.com')->first();
        $this->assertTrue($client->tags->contains('name', 'Site Octa'));
    }

    public function test_webhook_restores_soft_deleted_lead_and_updates_name(): void
    {
        $client = Client::factory()->create([
            'name' => 'Old Name',
            'email' => 'john@example.com',
            'phone' => '11999999999'
        ]);
        $client->delete();

        $this->assertSoftDeleted('clients', ['id' => $client->id]);

        $payload = [
            'nome' => 'New Name',
            'email' => 'john@example.com',
            'telefone' => '11999999999'
        ];

        $response = $this->postJson('/api/webhooks/leads', $payload);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $client->refresh();
        $this->assertFalse($client->trashed());
        $this->assertEquals('New Name', $client->name);
    }

    public function test_webhook_does_not_update_name_if_lead_is_active(): void
    {
        $client = Client::factory()->create([
            'name' => 'Existing Name',
            'email' => 'john@example.com',
            'phone' => '11999999999'
        ]);

        $payload = [
            'nome' => 'Attempted New Name',
            'email' => 'john@example.com',
            'telefone' => '11999999999'
        ];

        $response = $this->postJson('/api/webhooks/leads', $payload);

        $response->assertStatus(200);
        
        $client->refresh();
        $this->assertEquals('Existing Name', $client->name);
    }
}
