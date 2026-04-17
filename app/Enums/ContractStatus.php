<?php

declare(strict_types=1);

namespace App\Enums;

enum ContractStatus: string
{
    case Draft    = 'draft';
    case Active   = 'active';
    case Expired  = 'expired';
    case Canceled = 'canceled';

    public function label(): string
    {
        return match($this) {
            self::Draft    => 'Rascunho',
            self::Active   => 'Ativo',
            self::Expired  => 'Expirado',
            self::Canceled => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Draft    => 'gray',
            self::Active   => 'green',
            self::Expired  => 'yellow',
            self::Canceled => 'red',
        };
    }
}
