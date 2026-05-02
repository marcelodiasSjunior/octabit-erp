<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Services\PipelineService;
use App\Services\DealSLAService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowupSettingsController extends Controller
{
    public function __construct(
        private readonly DealSLAService $service,
        private readonly PipelineService $pipelineService
    ) {}

    public function index(): View
    {
        return view('deals.followups.settings', [
            'pipelines' => $this->pipelineService->getActiveWithStages(),
            'slas' => $this->service->getAllSlas(),
            'rules' => $this->service->getAllRules(),
        ]);
    }

    public function storeSla(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pipeline_id' => ['required', 'exists:pipelines,id'],
            'stage_id' => ['nullable', 'exists:pipeline_stages,id'],
            'name' => ['required', 'string', 'max:255'],
            'response_sla_hours' => ['required', 'integer', 'min:1'],
            'followup_interval_days' => ['required', 'integer', 'min:1'],
            'escalation_threshold_days' => ['nullable', 'integer', 'min:1'],
            'priority' => ['required', 'integer', 'min:0'],
            'warning_hours_before' => ['required', 'integer', 'min:0'],
            'active' => ['nullable', 'boolean'],
        ]);

        $this->service->createSla($validated);

        return redirect()->route('followups.settings.index')->with('success', 'SLA criado com sucesso.');
    }

    public function storeRule(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pipeline_id' => ['required', 'exists:pipelines,id'],
            'stage_id' => ['nullable', 'exists:pipeline_stages,id'],
            'deal_sla_id' => ['nullable', 'exists:deal_slas,id'],
            'name' => ['required', 'string', 'max:255'],
            'trigger_type' => ['required', 'string', 'max:80'],
            'trigger_value' => ['required', 'string', 'max:80'],
            'action_type' => ['required', 'string', 'max:80'],
            'activity_type' => ['nullable', 'string', 'max:80'],
            'order' => ['required', 'integer', 'min:0'],
            'cooldown_hours' => ['required', 'integer', 'min:0'],
            'only_if_no_recent_activity' => ['nullable', 'boolean'],
            'active' => ['nullable', 'boolean'],
        ]);

        $this->service->createRule($validated);

        return redirect()->route('followups.settings.index')->with('success', 'Regra criada com sucesso.');
    }
}
