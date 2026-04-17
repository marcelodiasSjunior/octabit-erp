<?php

declare(strict_types=1);

use App\Models\Client;
use App\Models\AccountsReceivable;
use App\Enums\ClientStatus;
use App\Enums\PaymentStatus;

// ── Create AR manually ────────────────────────────────────────────

it('allows an admin to create an accounts receivable entry', function () {
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->post(route('receivable.store'), [
            'client_id'   => $client->id,
            'description' => 'Mensalidade Janeiro',
            'amount'      => 1500.00,
            'due_date'    => now()->addDays(10)->toDateString(),
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('accounts_receivable', [
        'client_id'   => $client->id,
        'description' => 'Mensalidade Janeiro',
        'status'      => PaymentStatus::Pending->value,
    ]);
});

it('auto-assigns pending status on creation', function () {
    $client = Client::factory()->create();

    $this->actingAs(adminUser())
        ->post(route('receivable.store'), [
            'client_id'   => $client->id,
            'description' => 'Setup Fee',
            'amount'      => 500,
            'due_date'    => now()->addDays(5)->toDateString(),
        ]);

    $ar = AccountsReceivable::first();
    expect($ar->status)->toBe(PaymentStatus::Pending);
});

// ── Mark as paid ──────────────────────────────────────────────────

it('allows marking an accounts receivable as paid', function () {
    $client = Client::factory()->create();
    $ar = AccountsReceivable::factory()->create([
        'client_id'    => $client->id,
        'status'       => PaymentStatus::Pending,
        'payment_date' => null,
    ]);

    $paymentDate = now()->toDateString();

    $this->actingAs(adminUser())
        ->patch(route('receivable.mark-paid', $ar), [
            'payment_date' => $paymentDate,
        ])
        ->assertRedirect();

    $ar->refresh();
    expect($ar->status)->toBe(PaymentStatus::Paid);
    expect($ar->payment_date->toDateString())->toBe($paymentDate);
});

// ── List overdue ──────────────────────────────────────────────────

it('lists overdue accounts receivable', function () {
    $client = Client::factory()->create();

    AccountsReceivable::factory()->create([
        'client_id'    => $client->id,
        'description'  => 'Overdue Bill',
        'due_date'     => now()->subDays(5)->toDateString(),
        'status'       => PaymentStatus::Overdue,
        'payment_date' => null,
    ]);

    AccountsReceivable::factory()->create([
        'client_id'    => $client->id,
        'description'  => 'Future Bill',
        'due_date'     => now()->addDays(5)->toDateString(),
        'status'       => PaymentStatus::Pending,
        'payment_date' => null,
    ]);

    $this->actingAs(adminUser())
        ->get(route('receivable.index', ['status' => 'overdue']))
        ->assertSee('Overdue Bill')
        ->assertDontSee('Future Bill');
});
