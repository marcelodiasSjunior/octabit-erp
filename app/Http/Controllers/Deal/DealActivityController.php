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
    public function __construct(
        private readonly DealService $service
    ) {}

    public function store(Request $request, int $dealId): RedirectResponse
    {
        $validated = $request->validate([
            'type'         => ['required', 'in:' . implode(',', array_column(DealActivityType::cases(), 'value'))],
            'title'        => ['required', 'string', 'max:255'],
            'scheduled_at' => ['required', 'date'],
            'notes'        => ['nullable', 'string', 'max:2000'],
        ]);

        $this->service->addActivity($dealId, $validated, (int) $request->user()?->id);

        return redirect()->route('deals.show', $dealId)
            ->with('success', 'Atividade registrada.');
    }

    public function complete(int $dealId, int $activityId): RedirectResponse
    {
        $this->service->completeActivity($dealId, $activityId);

        return redirect()->route('deals.show', $dealId)
            ->with('success', 'Atividade concluída.');
    }

    public function destroy(int $dealId, int $activityId): RedirectResponse
    {
        $this->service->deleteActivity($dealId, $activityId);

        return redirect()->route('deals.show', $dealId)
            ->with('success', 'Atividade removida.');
    }
}
