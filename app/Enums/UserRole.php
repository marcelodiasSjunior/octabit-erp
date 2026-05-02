<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Admin        = 'admin';
    case Manager      = 'manager';
    case Operator     = 'operator';
    case MasterGlobal = 'master_global';
    case AdminEmpresa = 'admin_empresa';
    case User         = 'user';

    public function label(): string
    {
        return match($this) {
            self::Admin        => 'Administrador',
            self::Manager      => 'Gerente',
            self::Operator     => 'Operador',
            self::MasterGlobal => 'Master Global',
            self::AdminEmpresa => 'Administrador da Empresa',
            self::User         => 'Usuário',
        };
    }

    public function can(string $permission): bool
    {
        return match($this) {
            self::MasterGlobal => true,
            self::Admin, self::AdminEmpresa => true,
            self::Manager => in_array($permission, [
                'clients.view', 'clients.create', 'clients.edit',
                'services.view', 'services.create', 'services.edit',
                'products.view', 'products.create', 'products.edit',
                'contracts.view', 'contracts.create', 'contracts.edit',
                'financial.view', 'financial.create', 'financial.edit',
            ], true),
            self::Operator, self::User => in_array($permission, [
                'clients.view', 'clients.create', 'clients.edit',
                'financial.view',
                'contracts.view',
            ], true),
        };
    }
}
