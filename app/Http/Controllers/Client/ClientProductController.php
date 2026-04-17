<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientProductController extends Controller
{
    public function store(Request $request, int $clientId): RedirectResponse
    {
        $client = Client::findOrFail($clientId);

        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1|max:9999',
            'unit_price'   => 'nullable|numeric|min:0',
            'purchased_at' => 'required|date',
            'notes'        => 'nullable|string|max:500',
        ]);

        $client->clientProducts()->create($validated);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Produto registrado com sucesso.');
    }

    public function destroy(int $clientId, int $clientProductId): RedirectResponse
    {
        $clientProduct = ClientProduct::where('client_id', $clientId)
            ->findOrFail($clientProductId);

        $clientProduct->delete();

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Produto removido.');
    }
}
