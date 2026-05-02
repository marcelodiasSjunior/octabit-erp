<?php

declare(strict_types=1);

use App\Models\User;
use App\Enums\UserRole;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class)->in('Feature', 'Unit');

// ── Helpers ───────────────────────────────────────────────────────

function adminUser(): User
{
    return User::factory()->create(['role' => UserRole::Admin]);
}

function masterGlobalUser(): User
{
    return User::factory()->create(['role' => UserRole::MasterGlobal]);
}

function adminEmpresaUser(): User
{
    return User::factory()->create(['role' => UserRole::AdminEmpresa]);
}

function managerUser(): User
{
    return User::factory()->create(['role' => UserRole::Manager]);
}

function operatorUser(): User
{
    return User::factory()->create(['role' => UserRole::Operator]);
}
