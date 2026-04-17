<?php

declare(strict_types=1);

use App\Enums\PaymentStatus;

// ── PaymentStatus::calculate ──────────────────────────────────────

it('returns paid when payment_date is set', function () {
    $due     = new DateTimeImmutable('2024-01-01');
    $payment = new DateTimeImmutable('2024-01-15');

    expect(PaymentStatus::calculate($due, $payment))->toBe(PaymentStatus::Paid);
});

it('returns paid even if paid after the due date', function () {
    $due     = new DateTimeImmutable('2023-01-01');
    $payment = new DateTimeImmutable('2024-03-01');

    expect(PaymentStatus::calculate($due, $payment))->toBe(PaymentStatus::Paid);
});

it('returns overdue when due_date is in the past and no payment', function () {
    $pastDue = new DateTimeImmutable('yesterday');

    expect(PaymentStatus::calculate($pastDue, null))->toBe(PaymentStatus::Overdue);
});

it('returns pending when due_date is today and no payment', function () {
    $today = new DateTimeImmutable('today');

    expect(PaymentStatus::calculate($today, null))->toBe(PaymentStatus::Pending);
});

it('returns pending when due_date is in the future and no payment', function () {
    $future = new DateTimeImmutable('+30 days');

    expect(PaymentStatus::calculate($future, null))->toBe(PaymentStatus::Pending);
});

// ── Label & Color helpers ─────────────────────────────────────────

it('returns correct labels for each status', function (PaymentStatus $status, string $expectedLabel) {
    expect($status->label())->toBe($expectedLabel);
})->with([
    [PaymentStatus::Pending,  'Pendente'],
    [PaymentStatus::Paid,     'Pago'],
    [PaymentStatus::Overdue,  'Vencido'],
    [PaymentStatus::Canceled, 'Cancelado'],
]);

it('marks paid status as paid', function () {
    expect(PaymentStatus::Paid->isPaid())->toBeTrue();
    expect(PaymentStatus::Pending->isPaid())->toBeFalse();
});

it('marks overdue status as overdue', function () {
    expect(PaymentStatus::Overdue->isOverdue())->toBeTrue();
    expect(PaymentStatus::Paid->isOverdue())->toBeFalse();
});
