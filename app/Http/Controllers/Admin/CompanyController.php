<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    ) {}

    public function index()
    {
        $companies = Company::withCount('users')->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'cnpj'           => 'nullable|string|unique:companies,cnpj',
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        $this->companyService->createCompanyWithAdmin(
            ['name' => $validated['name'], 'cnpj' => $validated['cnpj']],
            [
                'name'     => $validated['admin_name'],
                'email'    => $validated['admin_email'],
                'password' => $validated['admin_password']
            ]
        );

        return redirect()->route('admin.companies.index')
            ->with('success', 'Empresa e administrador criados com sucesso.');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'cnpj'   => 'nullable|string|unique:companies,cnpj,' . $company->id,
            'status' => 'required|in:active,inactive',
        ]);

        $this->companyService->updateCompany($company, $validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Empresa atualizada com sucesso.');
    }

    public function destroy(Company $company)
    {
        $this->companyService->deleteCompany($company);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Empresa excluída com sucesso.');
    }
}
