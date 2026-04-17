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
        User::firstOrCreate(
            ['email' => 'admin@octabit.tech'],
            [
                'name'     => 'Admin OctaBit',
                'password' => Hash::make('password'),
                'role'     => UserRole::Admin,
            ]
        );

        User::firstOrCreate(
            ['email' => 'gerente@octabit.tech'],
            [
                'name'     => 'Gerente OctaBit',
                'password' => Hash::make('password'),
                'role'     => UserRole::Manager,
            ]
        );

        User::firstOrCreate(
            ['email' => 'operador@octabit.tech'],
            [
                'name'     => 'Operador OctaBit',
                'password' => Hash::make('password'),
                'role'     => UserRole::Operator,
            ]
        );
    }
}
