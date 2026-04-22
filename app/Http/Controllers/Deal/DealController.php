<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Enums\DealStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use App\Services\DealFollowupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class DealController extends Controller
{
    public function index(Request $request): View
    {
        $deals = Deal::query()
            ->with(['client', 'pipeline', 'stage'])
            ->latest()
            ->paginate(15);

        return view('deals.index', compact('deals'));
    }

    public function create(): View
    {
        $clients = Client::active()->orderBy('name')->get();
        $pipelines = Pipeline::query()
            ->where('active', true)
            ->with(['stages' => fn ($q) => $q->where('active', true)->orderBy('position')])
            ->orderBy('name')
            ->get();

        return view('deals.create', compact('clients', 'pipelines'));
    }

    public function store(Request $request, DealFollowupService $followupService): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'pipeline_id' => ['required', 'exists:pipelines,id'],
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
            'title' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric', 'min:0'],
            'expected_close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $stage = PipelineStage::query()
            ->where('id', $validated['stage_id'])
            ->where('pipeline_id', $validated['pipeline_id'])
            ->first();

        if (!$stage) {
            return back()->withErrors([
                'stage_id' => 'A etapa precisa pertencer ao pipeline selecionado.',
            ])->withInput();
        }

        $status = match ($stage->type) {
            'won' => DealStatus::Won,
            'lost' => DealStatus::Lost,
            default => DealStatus::Open,
        };

        $deal = Deal::create([
            ...$validated,
            'status' => $status,
            'closed_at' => $status === DealStatus::Open ? null : now(),
        ]);

        $followupService->initializeStageHistory($deal, $request->user()?->id);

        return redirect()->route('deals.index')
            ->with('success', 'Oportunidade criada com sucesso.');
    }

    public function show(int $id): View
    {
        $deal = Deal::with(['client', 'pipeline.stages', 'stage', 'activities.user'])->findOrFail($id);

        return view('deals.show', compact('deal'));
    }

    public function edit(int $id): View
    {
        $deal = Deal::with(['pipeline.stages'])->findOrFail($id);
        $clients = Client::active()->orderBy('name')->get();
        $pipelines = Pipeline::query()
            ->where('active', true)
            ->with(['stages' => fn ($q) => $q->where('active', true)->orderBy('position')])
            ->orderBy('name')
            ->get();

        return view('deals.edit', compact('deal', 'clients', 'pipelines'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $deal = Deal::findOrFail($id);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'pipeline_id' => ['required', 'exists:pipelines,id'],
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
            'title' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric', 'min:0'],
            'expected_close_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $stage = PipelineStage::query()
            ->where('id', $validated['stage_id'])
            ->where('pipeline_id', $validated['pipeline_id'])
            ->first();

        if (!$stage) {
            return back()->withErrors([
                'stage_id' => 'A etapa precisa pertencer ao pipeline selecionado.',
            ])->withInput();
        }

        $status = match ($stage->type) {
            'won' => DealStatus::Won,
            'lost' => DealStatus::Lost,
            default => DealStatus::Open,
        };

        $deal->update([
            ...$validated,
            'status' => $status,
            'closed_at' => $status === DealStatus::Open ? null : now(),
        ]);

        return redirect()->route('deals.show', $deal->id)
            ->with('success', 'Oportunidade atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', 'Oportunidade removida.');
    }

    public function moveStage(Request $request, int $id, DealFollowupService $followupService): JsonResponse|RedirectResponse
    {
        $deal = Deal::with('stage')->findOrFail($id);

        $validated = $request->validate([
            'stage_id' => [
                'required',
                Rule::exists('pipeline_stages', 'id')->where('pipeline_id', $deal->pipeline_id),
            ],
        ]);

        $stage = PipelineStage::findOrFail((int) $validated['stage_id']);

        $status = match ($stage->type) {
            'won'  => DealStatus::Won,
            'lost' => DealStatus::Lost,
            default => DealStatus::Open,
        };

        $followupService->recordStageTransition($deal, $stage, $request->user()?->id);

        $deal->update([
            'stage_id'  => $stage->id,
            'status'    => $status,
            'closed_at' => $status === DealStatus::Open ? null : now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $status->value]);
        }

        return redirect()->route('deals.show', $deal->id)
            ->with('success', 'Etapa atualizada com sucesso.');
    }

    public function kanban(Pipeline $pipeline): View
    {
        $pipeline->load([
            'stages' => fn ($q) => $q->where('active', true)->orderBy('position'),
            'stages.deals' => fn ($q) => $q->with('client')->whereNull('closed_at'),
        ]);

        return view('deals.kanban', compact('pipeline'));
    }
}
