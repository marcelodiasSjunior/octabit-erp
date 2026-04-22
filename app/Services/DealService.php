<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DealStatus;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class DealService
{
    public function countOpen(): int
    {
        return Deal::where('status', DealStatus::Open)->count();
    }

    public function countWonThisMonth(): int
    {
        return Deal::where('status', DealStatus::Won)
            ->whereMonth('closed_at', now()->month)
            ->whereYear('closed_at', now()->year)
            ->count();
    }

    /** Sum of (value × probability / 100) for all open deals */
    public function weightedPipeline(): float
    {
        return (float) Deal::join('pipeline_stages', 'pipeline_stages.id', '=', 'deals.stage_id')
            ->where('deals.status', DealStatus::Open)
            ->whereNull('deals.deleted_at')
            ->sum(DB::raw('deals.value * pipeline_stages.probability / 100'));
    }
}
