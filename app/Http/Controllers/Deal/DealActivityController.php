<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Enums\DealActivityType;
use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\DealActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class DealActivityController extends Controller
{
    public function store(Request $request, int $dealId): RedirectResponse
    {
        $deal = Deal::findOrFail($dealId);

        $validated = $request->validate([
            'type'         => ['required', 'in:' . implode(',', array_column(DealActivityType::cases(), 'value'))],
            'title'        => ['required', 'string', 'max:255'],
            'scheduled_at' => ['required', 'date'],
            'notes'        => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['deal_id'] = $deal->id;
        $validated['user_id'] = $request->user()->id;

        DealActivity::create($validated);

        return redirect()->route('deals.show', $deal->id)
            ->with('success', 'Atividade registrada.');
    }

    public function complete(int $dealId, int $activityId): RedirectResponse
    {
        Deal::findOrFail($dealId);

        $activity = DealActivity::where('deal_id', $dealId)->findOrFail($activityId);

        $activity->update([
            'done'         => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('deals.show', $dealId)
            ->with('success', 'Atividade concluída.');
    }

    public function destroy(int $dealId, int $activityId): RedirectResponse
    {
        Deal::findOrFail($dealId);

        $activity = DealActivity::where('deal_id', $dealId)->findOrFail($activityId);
        $activity->delete();

        return redirect()->route('deals.show', $dealId)
            ->with('success', 'Atividade removida.');
    }
}
