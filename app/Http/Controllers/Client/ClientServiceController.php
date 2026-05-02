<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientServiceController extends Controller
{
    public function __construct(
        private readonly ClientService $service
    ) {}

    public function store(Request $request, int $clientId): RedirectResponse
    {
        $validated = $request->validate([
            'service_id'   => 'required|exists:services,id',
            'custom_price' => 'nullable|numeric|min:0',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after:start_date',
            'status'       => 'required|in:active,suspended,canceled',
        ]);

        $this->service->addService($clientId, $validated);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Serviço vinculado com sucesso.');
    }

    public function destroy(int $clientId, int $clientServiceId): RedirectResponse
    {
        $this->service->removeService($clientId, $clientServiceId);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Vínculo de serviço removido.');
    }
}
