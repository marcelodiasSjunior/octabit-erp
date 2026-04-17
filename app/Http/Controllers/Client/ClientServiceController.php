<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Enums\ClientServiceStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientService as ClientServiceModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientServiceController extends Controller
{
    public function store(Request $request, int $clientId): RedirectResponse
    {
        $client = Client::findOrFail($clientId);

        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'custom_price' => 'nullable|numeric|min:0',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after:start_date',
            'status'       => 'required|in:active,suspended,canceled',
        ]);

        $client->clientServices()->create($validated);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Serviço vinculado com sucesso.');
    }

    public function destroy(int $clientId, int $clientServiceId): RedirectResponse
    {
        $clientService = ClientServiceModel::where('client_id', $clientId)
            ->findOrFail($clientServiceId);

        $clientService->delete();

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Vínculo de serviço removido.');
    }
}
