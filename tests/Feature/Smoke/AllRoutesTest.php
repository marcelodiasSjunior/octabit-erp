<?php

declare(strict_types=1);

use App\Models\Client;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Product;
use App\Models\AccountsReceivable;
use App\Models\AccountsPayable;
use App\Enums\PaymentStatus;

/**
 * Integration smoke test — every registered GET route must return 200.
 * Guards against 502 (Nginx/FPM miscommunication) and 500 (PHP errors).
 */

// ── Auth routes (guests) ──────────────────────────────────────────

it('GET /login returns 200 for guests', function () {
    $this->get(route('login'))->assertOk();
});

it('GET / redirects to login', function () {
    $this->get('/')->assertRedirect(route('login'));
});

it('unauthenticated requests redirect to login', function (string $route) {
    $this->get($route)->assertRedirect(route('login'));
})->with([
    ['/dashboard'],
    ['/clients'],
    ['/clients/create'],
    ['/services'],
    ['/services/create'],
    ['/products'],
    ['/products/create'],
    ['/contracts'],
    ['/contracts/create'],
    ['/financial/receivable'],
    ['/financial/receivable/create'],
    ['/financial/payable'],
    ['/financial/payable/create'],
]);

// ── Dashboard ─────────────────────────────────────────────────────

it('GET /dashboard returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewIs('dashboard.index');
});

// ── Clients ───────────────────────────────────────────────────────

it('GET /clients returns 200', function () {
    Client::factory()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('clients.index'))
        ->assertOk()
        ->assertViewIs('clients.index');
});

it('GET /clients/create returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('clients.create'))
        ->assertOk();
});

it('GET /clients/{id} returns 200', function () {
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('clients.show', $client))
        ->assertOk();
});

it('GET /clients/{id}/edit returns 200', function () {
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('clients.edit', $client))
        ->assertOk();
});

// ── Services ──────────────────────────────────────────────────────

it('GET /services returns 200', function () {
    Service::factory()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('services.index'))
        ->assertOk()
        ->assertViewIs('services.index');
});

it('GET /services/create returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('services.create'))
        ->assertOk();
});

it('GET /services/{id} returns 200', function () {
    $service = Service::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('services.show', $service))
        ->assertOk();
});

it('GET /services/{id}/edit returns 200', function () {
    $service = Service::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('services.edit', $service))
        ->assertOk();
});

// ── Products ──────────────────────────────────────────────────────

it('GET /products returns 200', function () {
    Product::factory()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('products.index'))
        ->assertOk()
        ->assertViewIs('products.index');
});

it('GET /products/create returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('products.create'))
        ->assertOk();
});

it('GET /products/{id} returns 200', function () {
    $product = Product::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('products.show', $product))
        ->assertOk();
});

it('GET /products/{id}/edit returns 200', function () {
    $product = Product::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('products.edit', $product))
        ->assertOk();
});

// ── Contracts ─────────────────────────────────────────────────────

it('GET /contracts returns 200', function () {
    Contract::factory()->count(2)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.index'))
        ->assertOk()
        ->assertViewIs('contracts.index');
});

it('GET /contracts/create returns 200', function () {
    Client::factory()->active()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.create'))
        ->assertOk();
});

it('GET /contracts/{id} returns 200', function () {
    $contract = Contract::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.show', $contract))
        ->assertOk();
});

it('GET /contracts/{id}/edit returns 200', function () {
    $contract = Contract::factory()->create();
    Client::factory()->active()->count(2)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.edit', $contract))
        ->assertOk();
});

// ── Financial: Receivable ─────────────────────────────────────────

it('GET /financial/receivable returns 200', function () {
    $client = Client::factory()->create();
    AccountsReceivable::factory()->count(3)->create(['client_id' => $client->id]);

    $this->actingAs(adminUser())
        ->get(route('receivable.index'))
        ->assertOk()
        ->assertViewIs('financial.receivable.index');
});

it('GET /financial/receivable/create returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('receivable.create'))
        ->assertOk();
});

// ── Financial: Payable ────────────────────────────────────────────

it('GET /financial/payable returns 200', function () {
    AccountsPayable::factory()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('payable.index'))
        ->assertOk()
        ->assertViewIs('financial.payable.index');
});

it('GET /financial/payable/create returns 200', function () {
    $this->actingAs(adminUser())
        ->get(route('payable.create'))
        ->assertOk();
});

// ── No 500/502 assertion helper ───────────────────────────────────

it('no route returns a server error for an active operator', function (string $route) {
    $client   = Client::factory()->active()->create();
    $service  = Service::factory()->create();
    $product  = Product::factory()->create();
    $contract = Contract::factory()->create();
    $ar       = AccountsReceivable::factory()->create(['client_id' => $client->id]);
    $ap       = AccountsPayable::factory()->create();

    $url = str_replace(
        ['{client}', '{service}', '{product}', '{contract}', '{ar}', '{ap}'],
        [$client->id, $service->id, $product->id, $contract->id, $ar->id, $ap->id],
        $route
    );

    $response = $this->actingAs(operatorUser())->get($url);

    expect($response->status())->not->toBeIn([500, 502, 503]);
})->with([
    ['/dashboard'],
    ['/clients'],
    ['/clients/create'],
    ['/clients/{client}'],
    ['/clients/{client}/edit'],
    ['/services'],
    ['/services/create'],
    ['/services/{service}'],
    ['/services/{service}/edit'],
    ['/products'],
    ['/products/create'],
    ['/products/{product}'],
    ['/products/{product}/edit'],
    ['/contracts'],
    ['/contracts/create'],
    ['/contracts/{contract}'],
    ['/contracts/{contract}/edit'],
    ['/financial/receivable'],
    ['/financial/receivable/create'],
    ['/financial/payable'],
    ['/financial/payable/create'],
]);
