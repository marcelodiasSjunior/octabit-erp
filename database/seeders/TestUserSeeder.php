<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'qa.admin@octabit.tech'],
            [
                'name' => 'QA Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
            ]
        );

        User::updateOrCreate(
            ['email' => 'qa.manager@octabit.tech'],
            [
                'name' => 'QA Manager',
                'password' => Hash::make('password'),
                'role' => UserRole::Manager,
            ]
        );

        User::updateOrCreate(
            ['email' => 'qa.operator@octabit.tech'],
            [
                'name' => 'QA Operator',
                'password' => Hash::make('password'),
                'role' => UserRole::Operator,
            ]
        );
    }
}
