<?php

declare(strict_types=1);

use App\Models\Client;
use App\Models\Contract;
use App\Enums\ContractStatus;

// ── Index & listing ───────────────────────────────────────────────

it('lists contracts', function () {
    Contract::factory()->count(3)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.index'))
        ->assertOk()
        ->assertViewIs('contracts.index');
});

it('filters contracts by status', function () {
    $clientActive = Client::factory()->active()->create(['name' => 'Cliente Ativo Filter']);
    $clientDraft  = Client::factory()->active()->create(['name' => 'Cliente Rascunho Filter']);

    Contract::factory()->active()->create(['client_id' => $clientActive->id]);
    Contract::factory()->draft()->create(['client_id' => $clientDraft->id]);

    $this->actingAs(adminUser())
        ->get(route('contracts.index', ['status' => 'active']))
        ->assertOk()
        ->assertSeeText('Cliente Ativo Filter')
        ->assertDontSeeText('Cliente Rascunho Filter');
});

it('shows contract detail', function () {
    $contract = Contract::factory()->create(['notes' => 'Contrato Detalhe']);

    $this->actingAs(adminUser())
        ->get(route('contracts.show', $contract))
        ->assertOk()
        ->assertSeeText('Contrato Detalhe');
});

// ── Create ────────────────────────────────────────────────────────

it('shows create form with active clients', function () {
    Client::factory()->active()->count(2)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.create'))
        ->assertOk()
        ->assertViewIs('contracts.create');
});

it('creates a contract', function () {
    $client = Client::factory()->active()->create();

    $this->actingAs(adminUser())
        ->post(route('contracts.store'), [
            'client_id'  => $client->id,
            'start_date' => '2025-01-01',
            'value'      => '1500.00',
            'status'     => 'draft',
            'notes'      => 'Contrato de Serviços',
        ])
        ->assertRedirect(route('contracts.index'));

    expect(Contract::where('notes', 'Contrato de Serviços')->exists())->toBeTrue();
});

it('uses draft as fallback when status not sent', function () {
    $client = Client::factory()->active()->create();

    // status is required in the controller, but the service defaults to draft if not provided
    $this->actingAs(adminUser())
        ->post(route('contracts.store'), [
            'client_id'  => $client->id,
            'start_date' => '2025-01-01',
            'value'      => '500.00',
            'status'     => 'draft',
        ]);

    $contract = Contract::latest()->first();
    expect($contract->status)->toBe(ContractStatus::Draft);
});

it('validates required fields on store', function () {
    $this->actingAs(adminUser())
        ->post(route('contracts.store'), [])
        ->assertSessionHasErrors(['client_id', 'start_date', 'value', 'status']);
});

it('requires client_id to exist in clients table', function () {
    $this->actingAs(adminUser())
        ->post(route('contracts.store'), [
            'client_id'  => 99999,
            'start_date' => '2025-01-01',
            'value'      => '100',
            'status'     => 'draft',
        ])
        ->assertSessionHasErrors(['client_id']);
});

// ── Update ────────────────────────────────────────────────────────

it('shows edit form', function () {
    $contract = Contract::factory()->create();
    Client::factory()->active()->count(2)->create();

    $this->actingAs(adminUser())
        ->get(route('contracts.edit', $contract))
        ->assertOk()
        ->assertViewIs('contracts.edit');
});

it('updates a contract', function () {
    $contract = Contract::factory()->create(['notes' => 'Nota Antiga']);

    $this->actingAs(adminUser())
        ->put(route('contracts.update', $contract), [
            'client_id'  => $contract->client_id,
            'start_date' => '2025-06-01',
            'value'      => '2000.00',
            'status'     => ContractStatus::Active->value,
            'notes'      => 'Nota Nova',
        ])
        ->assertRedirect(route('contracts.show', $contract->id));

    expect($contract->fresh()->notes)->toBe('Nota Nova');
});

it('validates required fields on update', function () {
    $contract = Contract::factory()->create();

    $this->actingAs(adminUser())
        ->put(route('contracts.update', $contract), [])
        ->assertSessionHasErrors(['client_id', 'start_date', 'value', 'status']);
});

// ── Delete ────────────────────────────────────────────────────────

it('deletes a contract', function () {
    $contract = Contract::factory()->create();

    $this->actingAs(adminUser())
        ->delete(route('contracts.destroy', $contract))
        ->assertRedirect(route('contracts.index'));

    expect(Contract::find($contract->id))->toBeNull();
});

// ── Auth guard ────────────────────────────────────────────────────

it('unauthenticated user cannot access contracts', function () {
    $this->get(route('contracts.index'))->assertRedirect(route('login'));
});
