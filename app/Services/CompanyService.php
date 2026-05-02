<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyService
{
    /**
     * Create a company and its first administrator user.
     */
    public function createCompanyWithAdmin(array $companyData, array $adminData): Company
    {
        return DB::transaction(function () use ($companyData, $adminData) {
            $company = Company::create($companyData);

            $user = User::create([
                'company_id' => $company->id,
                'name'       => $adminData['name'],
                'email'      => $adminData['email'],
                'password'   => Hash::make($adminData['password']),
                'role'       => UserRole::AdminEmpresa,
            ]);

            return $company;
        });
    }

    public function updateCompany(Company $company, array $data): bool
    {
        return $company->update($data);
    }

    public function deleteCompany(Company $company): bool
    {
        return $company->delete();
    }
}
