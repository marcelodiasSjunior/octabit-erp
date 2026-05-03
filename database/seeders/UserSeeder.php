<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Create Main Company ──────────────────────────────────────
        $octabit = \App\Models\Company::updateOrCreate(
            ['cnpj' => '00.000.000/0001-00'],
            [
                'name'      => 'Octabit Tech',
                'subdomain' => 'octabit',
                'status'    => 'active',
                'plan'      => 'enterprise',
            ]
        );

        // ── Master Global Admin ──────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@octabit.tech'],
            [
                'company_id' => $octabit->id,
                'name'       => 'Admin OctaBit',
                'password'   => Hash::make('password'),
                'role'       => UserRole::MasterGlobal,
            ]
        );

        User::updateOrCreate(
            ['email' => 'gerente@octabit.tech'],
            [
                'company_id' => $octabit->id,
                'name'       => 'Gerente OctaBit',
                'password'   => Hash::make('password'),
                'role'       => UserRole::Manager,
            ]
        );

        User::updateOrCreate(
            ['email' => 'operador@octabit.tech'],
            [
                'company_id' => $octabit->id,
                'name'       => 'Operador OctaBit',
                'password'   => Hash::make('password'),
                'role'       => UserRole::Operator,
            ]
        );
    }
}
