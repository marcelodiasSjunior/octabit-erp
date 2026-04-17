<?php

declare(strict_types=1);

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Services\ServiceCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceCatalogService $service
    ) {}

    public function index(Request $request): View
    {
        $filters  = $request->only(['search', 'type', 'active']);
        $services = $this->service->list($filters);

        return view('services.index', compact('services', 'filters'));
    }

    public function create(): View
    {
        return view('services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:recurring,one_time,hybrid',
            'base_price'  => 'required|numeric|min:0',
            'setup_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'active'      => 'nullable|boolean',
        ]);

        $this->service->create($validated);

        return redirect()->route('services.index')
            ->with('success', 'Serviço criado com sucesso.');
    }

    public function show(int $id): View
    {
        $service = $this->service->findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function edit(int $id): View
    {
        $service = $this->service->findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:recurring,one_time,hybrid',
            'base_price'  => 'required|numeric|min:0',
            'setup_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'active'      => 'nullable|boolean',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('services.show', $id)
            ->with('success', 'Serviço atualizado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('services.index')
            ->with('success', 'Serviço removido.');
    }
}
