<?php

declare(strict_types=1);

namespace App\Enums;

enum DealActivityType: string
{
    case Call     = 'call';
    case Email    = 'email';
    case Meeting  = 'meeting';
    case Task     = 'task';
    case WhatsApp = 'whatsapp';

    public function label(): string
    {
        return match ($this) {
            self::Call     => 'Ligação',
            self::Email    => 'E-mail',
            self::Meeting  => 'Reunião',
            self::Task     => 'Tarefa',
            self::WhatsApp => 'WhatsApp',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Call     => 'phone',
            self::Email    => 'mail',
            self::Meeting  => 'calendar',
            self::Task     => 'check-square',
            self::WhatsApp => 'message-circle',
        };
    }
}
