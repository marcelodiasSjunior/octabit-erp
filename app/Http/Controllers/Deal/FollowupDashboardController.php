<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Services\PipelineService;
use App\Services\DealSLAService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowupDashboardController extends Controller
{
    public function __construct(
        private readonly DealSLAService $service,
        private readonly PipelineService $pipelineService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['pipeline_id', 'severity']);
        
        $violations = $this->service->getViolationsPaginated($filters);
        $stats = $this->service->getDashboardStats();

        return view('deals.followups.dashboard', array_merge($stats, [
            'pipelines' => $this->pipelineService->getActiveWithStages(),
            'violations' => $violations,
            'severityFilter' => $request->string('severity')->toString(),
            'pipelineFilter' => $request->integer('pipeline_id'),
        ]));
    }
}
