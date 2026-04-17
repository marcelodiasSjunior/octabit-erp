<?php

declare(strict_types=1);

namespace App\Enums;

enum ClientStatus: string
{
    case Lead     = 'lead';
    case Active   = 'active';
    case Inactive = 'inactive';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Lead     => 'Lead',
            self::Active   => 'Ativo',
            self::Inactive => 'Inativo',
            self::Canceled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Lead     => 'blue',
            self::Active   => 'green',
            self::Inactive => 'yellow',
            self::Canceled => 'red',
        };
    }

    public function isActive(): bool
    {
        return $this === self::Active;
    }
}
