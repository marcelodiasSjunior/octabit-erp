<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientInteractionController extends Controller
{
    public function __construct(
        private readonly ClientService $service
    ) {}

    public function store(Request $request, int $clientId): RedirectResponse
    {
        $validated = $request->validate([
            'type'        => 'required|in:call,email,meeting,note,whatsapp',
            'description' => 'required|string|max:2000',
            'occurred_at' => 'required|date',
        ]);

        $this->service->addInteraction($clientId, $validated, (int) $request->user()?->id);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Interação registrada.');
    }

    public function destroy(int $clientId, int $interactionId): RedirectResponse
    {
        $this->service->deleteInteraction($clientId, $interactionId);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Interação removida.');
    }
}
