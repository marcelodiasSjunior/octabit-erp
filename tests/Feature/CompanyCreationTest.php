<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_global_can_access_company_creation_page(): void
    {
        $user = masterGlobalUser();

        $response = $this->actingAs($user)->get(route('admin.companies.create'));

        $response->assertStatus(200);
        $response->assertSee('Nova Empresa');
    }

    public function test_master_global_can_create_a_company(): void
    {
        $user = masterGlobalUser();

        $companyData = [
            'name' => 'Nova Empresa Teste',
            'cnpj' => '12.345.678/0001-90',
            'admin_name' => 'Admin Teste',
            'admin_email' => 'admin.teste@empresa.com',
            'admin_password' => 'password123',
            'admin_password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($user)->post(route('admin.companies.store'), $companyData);

        $response->assertRedirect(route('admin.companies.index'));
        $this->assertDatabaseHas('companies', ['name' => 'Nova Empresa Teste', 'cnpj' => '12.345.678/0001-90']);
        $this->assertDatabaseHas('users', ['email' => 'admin.teste@empresa.com', 'name' => 'Admin Teste']);
    }
}
