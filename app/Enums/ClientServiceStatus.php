<?php

declare(strict_types=1);

namespace App\Enums;

enum ClientServiceStatus: string
{
    case Active    = 'active';
    case Suspended = 'suspended';
    case Canceled  = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Active    => 'Ativo',
            self::Suspended => 'Suspenso',
            self::Canceled  => 'Cancelado',
        };
    }
}
