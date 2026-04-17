<?php

declare(strict_types=1);

use App\Models\AccountsPayable;
use App\Enums\PaymentStatus;

// ── Index & listing ───────────────────────────────────────────────

it('lists payables', function () {
    AccountsPayable::factory()->count(5)->create();

    $this->actingAs(adminUser())
        ->get(route('payable.index'))
        ->assertOk()
        ->assertViewIs('financial.payable.index');
});

it('filters payables by status', function () {
    AccountsPayable::factory()->create([
        'description' => 'Conta Pendente',
        'status'      => PaymentStatus::Pending,
    ]);
    AccountsPayable::factory()->paid()->create([
        'description' => 'Conta Paga',
    ]);

    $this->actingAs(adminUser())
        ->get(route('payable.index', ['status' => 'pending']))
        ->assertOk()
        ->assertSeeText('Conta Pendente')
        ->assertDontSeeText('Conta Paga');
});

// ── Create ────────────────────────────────────────────────────────

it('shows create form', function () {
    $this->actingAs(adminUser())
        ->get(route('payable.create'))
        ->assertOk()
        ->assertViewIs('financial.payable.create');
});

it('creates a payable', function () {
    $this->actingAs(adminUser())
        ->post(route('payable.store'), [
            'description' => 'Aluguel do escritório',
            'amount'      => '1200.00',
            'due_date'    => '2025-07-10',
            'category'    => 'infrastructure',
        ])
        ->assertRedirect(route('payable.index'));

    expect(AccountsPayable::where('description', 'Aluguel do escritório')->exists())->toBeTrue();
});

it('forces status to pending on creation', function () {
    $this->actingAs(adminUser())
        ->post(route('payable.store'), [
            'description' => 'Força Pendente',
            'amount'      => '500.00',
            'due_date'    => '2025-07-10',
        ]);

    $payable = AccountsPayable::where('description', 'Força Pendente')->first();
    expect($payable->status)->toBe(PaymentStatus::Pending);
});

it('validates required fields on store', function () {
    $this->actingAs(adminUser())
        ->post(route('payable.store'), [])
        ->assertSessionHasErrors(['description', 'amount', 'due_date']);
});

// ── Mark as paid ──────────────────────────────────────────────────

it('marks a payable as paid', function () {
    $payable = AccountsPayable::factory()->create(['status' => PaymentStatus::Pending]);

    $this->actingAs(adminUser())
        ->patch(route('payable.mark-paid', $payable->id), [
            'payment_date' => now()->toDateString(),
        ])
        ->assertRedirect();

    expect($payable->fresh()->status)->toBe(PaymentStatus::Paid);
});

it('validates payment_date when marking as paid', function () {
    $payable = AccountsPayable::factory()->create(['status' => PaymentStatus::Pending]);

    $this->actingAs(adminUser())
        ->patch(route('payable.mark-paid', $payable->id), [])
        ->assertSessionHasErrors(['payment_date']);
});

// ── Delete ────────────────────────────────────────────────────────

it('deletes a payable', function () {
    $payable = AccountsPayable::factory()->create();

    $this->actingAs(adminUser())
        ->delete(route('payable.destroy', $payable->id))
        ->assertRedirect(route('payable.index'));

    expect(AccountsPayable::find($payable->id))->toBeNull();
});

// ── Auth guard ────────────────────────────────────────────────────

it('unauthenticated user cannot access payables', function () {
    $this->get(route('payable.index'))->assertRedirect(route('login'));
});
