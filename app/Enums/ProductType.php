<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductType: string
{
    case Saas    = 'saas';
    case License = 'license';
    case OneTime = 'one_time';

    public function label(): string
    {
        return match($this) {
            self::Saas    => 'SaaS (Assinatura)',
            self::License => 'Licença',
            self::OneTime => 'Compra Única',
        };
    }
}
