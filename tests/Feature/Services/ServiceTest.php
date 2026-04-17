<?php

declare(strict_types=1);

use App\Models\Service;
use App\Enums\ServiceType;

// ── Index & listing ───────────────────────────────────────────────

it('lists services', function () {
    Service::factory()->count(5)->create();

    $this->actingAs(adminUser())
        ->get(route('services.index'))
        ->assertOk()
        ->assertSeeText(Service::first()->name);
});

it('filters services by type', function () {
    Service::factory()->create(['name' => 'Recorrente X', 'type' => ServiceType::Recurring]);
    Service::factory()->create(['name' => 'Avulso Y',     'type' => ServiceType::OneTime]);

    $this->actingAs(adminUser())
        ->get(route('services.index', ['type' => 'recurring']))
        ->assertOk()
        ->assertSeeText('Recorrente X')
        ->assertDontSeeText('Avulso Y');
});

it('shows service detail', function () {
    $service = Service::factory()->create(['description' => 'Detalhe importante']);

    $this->actingAs(adminUser())
        ->get(route('services.show', $service))
        ->assertOk()
        ->assertSeeText('Detalhe importante');
});

// ── Create ────────────────────────────────────────────────────────

it('shows create form', function () {
    $this->actingAs(adminUser())
        ->get(route('services.create'))
        ->assertOk()
        ->assertViewIs('services.create');
});

it('creates a service', function () {
    $this->actingAs(adminUser())
        ->post(route('services.store'), [
            'name'        => 'Suporte Premium',
            'type'        => 'recurring',
            'base_price'  => '99.90',
            'description' => 'Serviço de suporte mensal',
            'active'      => '1',
        ])
        ->assertRedirect(route('services.index'));

    expect(Service::where('name', 'Suporte Premium')->exists())->toBeTrue();
});

it('validates required fields on store', function () {
    $this->actingAs(adminUser())
        ->post(route('services.store'), [])
        ->assertSessionHasErrors(['name', 'type', 'base_price']);
});

it('validates type must be in allowed list on store', function () {
    $this->actingAs(adminUser())
        ->post(route('services.store'), [
            'name'       => 'X',
            'type'       => 'invalid_type',
            'base_price' => '50',
        ])
        ->assertSessionHasErrors(['type']);
});

// ── Update ────────────────────────────────────────────────────────

it('shows edit form', function () {
    $service = Service::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('services.edit', $service))
        ->assertOk()
        ->assertViewIs('services.edit');
});

it('updates a service', function () {
    $service = Service::factory()->create(['name' => 'Antigo Nome']);

    $this->actingAs(adminUser())
        ->put(route('services.update', $service), [
            'name'       => 'Novo Nome',
            'type'       => $service->type->value,
            'base_price' => '150.00',
            'active'     => '1',
        ])
        ->assertRedirect(route('services.show', $service->id));

    expect($service->fresh()->name)->toBe('Novo Nome');
});

it('validates required fields on update', function () {
    $service = Service::factory()->create();

    $this->actingAs(adminUser())
        ->put(route('services.update', $service), [])
        ->assertSessionHasErrors(['name', 'type', 'base_price']);
});

// ── Delete ────────────────────────────────────────────────────────

it('deletes a service', function () {
    $service = Service::factory()->create();

    $this->actingAs(adminUser())
        ->delete(route('services.destroy', $service))
        ->assertRedirect(route('services.index'));

    expect(Service::find($service->id))->toBeNull();
});

// ── Auth guard ────────────────────────────────────────────────────

it('unauthenticated user cannot access services', function () {
    $this->get(route('services.index'))->assertRedirect(route('login'));
});
