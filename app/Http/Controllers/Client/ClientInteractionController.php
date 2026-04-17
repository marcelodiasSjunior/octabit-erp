<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Enums\InteractionType;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientInteraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ClientInteractionController extends Controller
{
    public function store(Request $request, int $clientId): RedirectResponse
    {
        Client::findOrFail($clientId);

        $validated = $request->validate([
            'type'        => 'required|in:call,email,meeting,note,whatsapp',
            'description' => 'required|string|max:2000',
            'occurred_at' => 'required|date',
        ]);

        $validated['client_id'] = $clientId;
        $validated['user_id']   = $request->user()->id;

        ClientInteraction::create($validated);

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Interação registrada.');
    }

    public function destroy(int $clientId, int $interactionId): RedirectResponse
    {
        $interaction = ClientInteraction::where('client_id', $clientId)
            ->findOrFail($interactionId);

        $interaction->delete();

        return redirect()->route('clients.show', $clientId)
            ->with('success', 'Interação removida.');
    }
}
