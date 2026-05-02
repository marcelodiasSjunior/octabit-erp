<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientProductController extends Controller
{
    public function __construct(
        private readonly ClientService $service
    ) {}

    public function store(Request $request, int $clientId): RedirectResponse
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1|max:9999',
            'unit_price'   => 'nullable|numeric|min:0',
            'purchased_at' => 'required|date',
            'notes'        => 'nullable|string|max:500',
        ]);

        $this->service->addProduct($clientId, $validated);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Produto registrado com sucesso.');
    }

    public function destroy(int $clientId, int $clientProductId): RedirectResponse
    {
        $this->service->removeProduct($clientId, $clientProductId);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Produto removido.');
    }
}
