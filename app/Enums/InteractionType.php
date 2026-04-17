<?php

declare(strict_types=1);

namespace App\Enums;

enum InteractionType: string
{
    case Call      = 'call';
    case Email     = 'email';
    case Meeting   = 'meeting';
    case Note      = 'note';
    case Whatsapp  = 'whatsapp';

    public function label(): string
    {
        return match($this) {
            self::Call     => 'Ligação',
            self::Email    => 'E-mail',
            self::Meeting  => 'Reunião',
            self::Note     => 'Anotação',
            self::Whatsapp => 'WhatsApp',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Call     => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
            self::Email    => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            self::Meeting  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            self::Note     => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            self::Whatsapp => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Call     => 'text-blue-400 bg-blue-500/10',
            self::Email    => 'text-purple-400 bg-purple-500/10',
            self::Meeting  => 'text-amber-400 bg-amber-500/10',
            self::Note     => 'text-slate-400 bg-slate-500/10',
            self::Whatsapp => 'text-green-400 bg-green-500/10',
        };
    }
}
