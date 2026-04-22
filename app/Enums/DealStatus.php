<?php

declare(strict_types=1);

namespace App\Enums;

enum DealStatus: string
{
    case Open = 'open';
    case Won = 'won';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Aberto',
            self::Won => 'Ganho',
            self::Lost => 'Perdido',
        };
    }
}
