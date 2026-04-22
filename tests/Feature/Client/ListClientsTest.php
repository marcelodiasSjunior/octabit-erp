<?php

declare(strict_types=1);

use App\Models\Client;
use App\Enums\ClientStatus;

// ── LIST ──────────────────────────────────────────────────────────

it('displays the clients list page', function () {
    Client::factory()->count(3)->active()->create();

    $this->actingAs(adminUser())
        ->get(route('clients.index'))
        ->assertOk()
        ->assertViewIs('clients.index')
        ->assertViewHas('clients');
});

it('requires authentication to view clients list', function () {
    $this->get(route('clients.index'))
        ->assertRedirect(route('login'));
});

it('shows only non-deleted clients', function () {
    $active = Client::factory()->active()->create(['name' => 'Visible Client']);
    $deleted = Client::factory()->active()->create(['name' => 'Deleted Client']);
    $deleted->delete();

    $this->actingAs(adminUser())
        ->get(route('clients.index'))
        ->assertSee('Visible Client')
        ->assertDontSee('Deleted Client');
});

it('does not show leads on clients list by default', function () {
    Client::factory()->create(['name' => 'Lead Hidden', 'status' => ClientStatus::Lead]);
    Client::factory()->create(['name' => 'Client Visible', 'status' => ClientStatus::Active]);

    $this->actingAs(adminUser())
        ->get(route('clients.index'))
        ->assertSee('Client Visible')
        ->assertDontSee('Lead Hidden');
});

it('shows only leads on leads list by default', function () {
    Client::factory()->create(['name' => 'Lead Visible', 'status' => ClientStatus::Lead]);
    Client::factory()->create(['name' => 'Client Hidden', 'status' => ClientStatus::Active]);

    $this->actingAs(adminUser())
        ->get(route('leads.index'))
        ->assertSee('Lead Visible')
        ->assertDontSee('Client Hidden');
});

// ── SHOW ──────────────────────────────────────────────────────────

it('shows a single client', function () {
    $client = Client::factory()->create(['name' => 'Carlos Oliveira']);

    $this->actingAs(adminUser())
        ->get(route('clients.show', $client))
        ->assertOk()
        ->assertViewIs('clients.show')
    ->assertViewHas('client', fn (Client $viewClient) => $viewClient->id === $client->id && $viewClient->name === 'Carlos Oliveira');
});

it('returns 404 for a non-existent client', function () {
    $this->actingAs(adminUser())
        ->get(route('clients.show', 99999))
        ->assertNotFound();
});

it('returns 404 for a soft-deleted client', function () {
    $client = Client::factory()->create();
    $client->delete();

    $this->actingAs(adminUser())
        ->get(route('clients.show', $client->id))
        ->assertNotFound();
});

// ── FILTER / SEARCH ───────────────────────────────────────────────

it('can filter clients by status', function () {
    Client::factory()->create(['name' => 'Active One', 'status' => ClientStatus::Active]);
    Client::factory()->create(['name' => 'Lead One', 'status' => ClientStatus::Lead]);

    $this->actingAs(adminUser())
        ->get(route('clients.index', ['status' => ClientStatus::Active->value]))
        ->assertSee('Active One')
        ->assertDontSee('Lead One');
});
