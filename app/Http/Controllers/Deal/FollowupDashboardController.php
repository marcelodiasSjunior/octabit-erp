<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Models\DealSLAViolation;
use App\Models\Pipeline;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowupDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $query = DealSLAViolation::query()->with(['deal.pipeline', 'deal.stage']);

        if ($request->filled('pipeline_id')) {
            $query->whereHas('deal', fn ($q) => $q->where('pipeline_id', (int) $request->integer('pipeline_id')));
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->string('severity')->toString());
        }

        $violations = $query->latest('due_at')->paginate(20)->withQueryString();

        return view('deals.followups.dashboard', [
            'pipelines' => Pipeline::ordered()->get(),
            'violations' => $violations,
            'severityFilter' => $request->string('severity')->toString(),
            'pipelineFilter' => $request->integer('pipeline_id'),
            'totalUnresolved' => DealSLAViolation::where('resolved', false)->count(),
            'totalCritical' => DealSLAViolation::where('resolved', false)->where('severity', 'critical')->count(),
            'totalSevere' => DealSLAViolation::where('resolved', false)->where('severity', 'severe')->count(),
        ]);
    }
}
