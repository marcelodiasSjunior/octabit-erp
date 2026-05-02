<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_empresa_can_access_user_creation_page(): void
    {
        $user = adminEmpresaUser();

        $response = $this->actingAs($user)->get(route('settings.users.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Usuário');
    }

    public function test_admin_empresa_can_create_a_user(): void
    {
        $admin = adminEmpresaUser();

        $userData = [
            'name' => 'Novo Funcionario',
            'email' => 'funcionario@empresa.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::Operator->value,
        ];

        $response = $this->actingAs($admin)->post(route('settings.users.store'), $userData);

        $response->assertRedirect(route('settings.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'funcionario@empresa.com',
            'name' => 'Novo Funcionario',
            'company_id' => $admin->company_id,
            'role' => UserRole::Operator->value
        ]);
    }
}
