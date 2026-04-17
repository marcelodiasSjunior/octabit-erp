<?php

declare(strict_types=1);

namespace App\Enums;

enum ServiceType: string
{
    case Recurring = 'recurring';
    case OneTime   = 'one_time';
    case Hybrid    = 'hybrid';

    public function label(): string
    {
        return match($this) {
            self::Recurring => 'Recorrente',
            self::OneTime   => 'Único',
            self::Hybrid    => 'Híbrido',
        };
    }

    public function isRecurring(): bool
    {
        return $this === self::Recurring || $this === self::Hybrid;
    }
}
