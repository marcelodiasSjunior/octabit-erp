<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\DTOs\Deal\CreateDealDTO;
use App\DTOs\Deal\UpdateDealDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Models\Pipeline;
use App\Services\ClientService;
use App\Services\DealService;
use App\Services\PipelineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DealController extends Controller
{
    public function __construct(
        private readonly DealService     $service,
        private readonly ClientService   $clientService,
        private readonly PipelineService $pipelineService
    ) {}

    public function index(): View
    {
        $deals = $this->service->list();
        return view('deals.index', compact('deals'));
    }

    public function kanban(Pipeline $pipeline): View
    {
        $pipeline->load([
            'stages' => fn ($q) => $q->where('active', true)->orderBy('position'),
            'stages.deals' => fn ($q) => $q->with('client')->whereNull('closed_at'),
        ]);

        return view('deals.kanban', compact('pipeline'));
    }

    public function create(): View
    {
        $clients   = $this->clientService->getEligibleForDeals();
        $pipelines = $this->pipelineService->getActiveWithStages();

        return view('deals.create', compact('clients', 'pipelines'));
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $dto = CreateDealDTO::fromArray($request->validated());
        
        $this->service->checkClientEligibility($dto->clientId);
        $this->service->create($dto, $request->user()?->id);

        return redirect()->route('deals.index')
            ->with('success', 'Oportunidade criada com sucesso.');
    }

    public function show(int $id): View
    {
        $deal = $this->service->findOrFail($id);
        $deal->load(['client', 'pipeline.stages', 'stage', 'activities.user']);

        return view('deals.show', compact('deal'));
    }

    public function edit(int $id): View
    {
        $deal      = $this->service->findOrFail($id);
        $clients   = $this->clientService->getEligibleForDeals();
        $pipelines = $this->pipelineService->getActiveWithStages();

        return view('deals.edit', compact('deal', 'clients', 'pipelines'));
    }

    public function update(UpdateDealRequest $request, int $id): RedirectResponse
    {
        $dto = UpdateDealDTO::fromArray($request->validated());

        $this->service->checkClientEligibility($dto->clientId);
        $deal = $this->service->update($id, $dto);

        return redirect()->route('deals.show', $deal->id)
            ->with('success', 'Oportunidade atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()->route('deals.index')
            ->with('success', 'Oportunidade removida.');
    }

    public function moveStage(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'stage_id' => ['required', 'exists:pipeline_stages,id'],
        ]);

        $deal = $this->service->moveStage($id, (int) $validated['stage_id'], $request->user()?->id);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $deal->status->value]);
        }

        return redirect()->route('deals.show', $deal->id)
            ->with('success', 'Etapa atualizada com sucesso.');
    }
}
