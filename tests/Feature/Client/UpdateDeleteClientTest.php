<?php

declare(strict_types=1);

use App\Models\Client;
use App\Enums\ClientStatus;

// ── UPDATE ────────────────────────────────────────────────────────

it('allows an admin to update a client', function () {
    $client = Client::factory()->create(['name' => 'Old Name']);

    $this->actingAs(adminUser())
        ->put(route('clients.update', $client), [
            'name'     => 'New Name',
            'email'    => $client->email,
            'document' => $client->document,
            'status'   => ClientStatus::Active->value,
        ])
        ->assertRedirect(route('clients.show', $client));

    $this->assertDatabaseHas('clients', [
        'id'   => $client->id,
        'name' => 'New Name',
    ]);
});

it('can change client status to active', function () {
    $client = Client::factory()->create(['status' => ClientStatus::Lead]);

    $this->actingAs(adminUser())
        ->put(route('clients.update', $client), [
            'name'     => $client->name,
            'email'    => $client->email,
            'document' => $client->document,
            'status'   => ClientStatus::Active->value,
        ]);

    $this->assertDatabaseHas('clients', [
        'id'     => $client->id,
        'status' => ClientStatus::Active->value,
    ]);
});

it('cannot update a client with someone elses email', function () {
    $existingClient = Client::factory()->create(['email' => 'taken@test.com']);
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->put(route('clients.update', $client), [
            'name'     => $client->name,
            'email'    => 'taken@test.com',
            'document' => $client->document,
            'status'   => $client->status->value,
        ])
        ->assertSessionHasErrors('email');
});

it('can update own email without conflict', function () {
    $client = Client::factory()->create(['email' => 'own@test.com']);

    $this->actingAs(adminUser())
        ->put(route('clients.update', $client), [
            'name'     => $client->name,
            'email'    => 'own@test.com',
            'document' => $client->document,
            'status'   => $client->status->value,
        ])
        ->assertRedirect();
});

it('requires authentication to update a client', function () {
    $client = Client::factory()->create();

    $this->put(route('clients.update', $client), ['name' => 'Hacker'])
        ->assertRedirect(route('login'));
});

// ── DELETE ────────────────────────────────────────────────────────

it('allows an admin to soft-delete a client', function () {
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->delete(route('clients.destroy', $client))
        ->assertRedirect(route('clients.index'));

    $this->assertSoftDeleted('clients', ['id' => $client->id]);
});

it('requires authentication to delete a client', function () {
    $client = Client::factory()->create();

    $this->delete(route('clients.destroy', $client))
        ->assertRedirect(route('login'));
});

it('prevents an operator from deleting a client', function () {
    $client = Client::factory()->create();

    $this->actingAs(operatorUser())
        ->delete(route('clients.destroy', $client))
        ->assertForbidden();
});
