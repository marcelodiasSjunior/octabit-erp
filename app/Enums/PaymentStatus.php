<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending  = 'pending';
    case Paid     = 'paid';
    case Overdue  = 'overdue';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Pending  => 'Pendente',
            self::Paid     => 'Pago',
            self::Overdue  => 'Vencido',
            self::Canceled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending  => 'yellow',
            self::Paid     => 'green',
            self::Overdue  => 'red',
            self::Canceled => 'gray',
        };
    }

    public function isPaid(): bool
    {
        return $this === self::Paid;
    }

    public function isOverdue(): bool
    {
        return $this === self::Overdue;
    }

    /**
     * Calculates the correct status given due_date and payment_date.
     * This is a pure business rule — no side effects.
     */
    public static function calculate(\DateTimeInterface $dueDate, ?\DateTimeInterface $paymentDate): self
    {
        if ($paymentDate !== null) {
            return self::Paid;
        }

        $today = new \DateTimeImmutable('today');

        if ($dueDate < $today) {
            return self::Overdue;
        }

        return self::Pending;
    }
}
