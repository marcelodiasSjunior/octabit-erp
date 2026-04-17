<?php

declare(strict_types=1);

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $service
    ) {}

    public function index(Request $request): View
    {
        $filters  = $request->only(['search', 'type', 'active']);
        $products = $this->service->list($filters);

        return view('products.index', compact('products', 'filters'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:saas,license,one_time',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'active'      => 'nullable|boolean',
        ]);

        $this->service->create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    public function show(int $id): View
    {
        $product = $this->service->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(int $id): View
    {
        $product = $this->service->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:saas,license,one_time',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'active'      => 'nullable|boolean',
        ]);

        $this->service->update($id, $validated);

        return redirect()->route('products.show', $id)
            ->with('success', 'Produto atualizado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('products.index')
            ->with('success', 'Produto removido.');
    }
}
