<?php

declare(strict_types=1);

use App\Models\Client;
use App\Enums\ClientStatus;

// ── CREATE ────────────────────────────────────────────────────────

it('allows an admin to create a client', function () {
    $user = adminUser();

    $response = $this->actingAs($user)
        ->post(route('clients.store'), [
            'name'     => 'João Silva',
            'email'    => 'joao@example.com',
            'document' => '12345678901',
            'status'   => ClientStatus::Lead->value,
        ]);

    $response->assertRedirect(route('leads.index'));
    $this->assertDatabaseHas('clients', [
        'email'  => 'joao@example.com',
        'status' => ClientStatus::Lead->value,
    ]);
});

it('allows a manager to create a client', function () {
    $user = managerUser();

    $this->actingAs($user)
        ->post(route('clients.store'), [
            'name'     => 'Empresa X',
            'email'    => 'empresa@x.com',
            'document' => '12345678000195',
            'status'   => ClientStatus::Lead->value,
        ])
        ->assertRedirect(route('leads.index'));

    $this->assertDatabaseHas('clients', ['email' => 'empresa@x.com']);
});

it('rejects duplicate email when creating a client', function () {
    Client::factory()->create(['email' => 'duplicate@test.com']);

    $this->actingAs(adminUser())
        ->post(route('clients.store'), [
            'name'     => 'Other Name',
            'email'    => 'duplicate@test.com',
            'document' => '98765432100',
            'status'   => ClientStatus::Lead->value,
        ])
        ->assertSessionHasErrors('email');
});

it('rejects duplicate document when creating a client', function () {
    Client::factory()->create(['document' => '11122233344']);

    $this->actingAs(adminUser())
        ->post(route('clients.store'), [
            'name'     => 'Another Person',
            'email'    => 'unique@test.com',
            'document' => '11122233344',
            'status'   => ClientStatus::Lead->value,
        ])
        ->assertSessionHasErrors('document');
});

it('requires name, email, document and status to create a client', function () {
    $this->actingAs(adminUser())
        ->post(route('clients.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'document', 'status']);
});

it('validates email format when creating a client', function () {
    $this->actingAs(adminUser())
        ->post(route('clients.store'), [
            'name'     => 'Test',
            'email'    => 'not-an-email',
            'document' => '11122233344',
            'status'   => ClientStatus::Lead->value,
        ])
        ->assertSessionHasErrors('email');
});

it('rejects an unauthenticated request to create a client', function () {
    $this->post(route('clients.store'), [
        'name'     => 'Hacker',
        'email'    => 'hacker@evil.com',
        'document' => '11122233344',
        'status'   => ClientStatus::Lead->value,
    ])->assertRedirect(route('login'));
});

it('saves optional fields (company_name, phone, notes)', function () {
    $this->actingAs(adminUser())
        ->post(route('clients.store'), [
            'name'         => 'Maria',
            'company_name' => 'Maria ME',
            'email'        => 'maria@example.com',
            'document'     => '22233344455',
            'phone'        => '11999990000',
            'status'       => ClientStatus::Active->value,
            'notes'        => 'VIP client',
        ]);

    $this->assertDatabaseHas('clients', [
        'email'        => 'maria@example.com',
        'company_name' => 'Maria ME',
        'phone'        => '11999990000',
        'notes'        => 'VIP client',
    ]);
});
