<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DealStatus;
use App\Models\Deal;
use App\Models\DealSLA;
use App\Models\DealStageHistory;
use App\Models\PipelineStage;

class DealFollowupService
{
    public function resolveApplicableSla(Deal $deal): ?DealSLA
    {
        return $deal->applicableSLAs()->first();
    }

    public function initializeStageHistory(Deal $deal, ?int $userId = null, ?string $triggerType = 'create'): DealStageHistory
    {
        $existing = $deal->stageHistory()->whereNull('exited_at')->latest('entered_at')->first();

        if ($existing) {
            return $existing;
        }

        $stage = $deal->stage()->first();

        return $deal->stageHistory()->create([
            'from_stage_id' => null,
            'to_stage_id' => $deal->stage_id,
            'entered_at' => now(),
            'user_id' => $userId,
            'trigger_type' => $triggerType,
            'deal_value_at_stage' => $deal->value,
            'probability_at_stage' => $stage?->probability,
            'was_won_or_lost' => $deal->status !== DealStatus::Open,
        ]);
    }

    public function recordStageTransition(
        Deal $deal,
        PipelineStage $toStage,
        ?int $userId = null,
        ?string $triggerType = 'manual'
    ): DealStageHistory {
        $currentHistory = $deal->stageHistory()->whereNull('exited_at')->latest('entered_at')->first();

        if (!$currentHistory) {
            $currentHistory = $this->initializeStageHistory($deal, $userId, 'backfill');
        }

        $currentHistory->markExit();

        return $deal->stageHistory()->create([
            'from_stage_id' => $deal->stage_id,
            'to_stage_id' => $toStage->id,
            'entered_at' => now(),
            'user_id' => $userId,
            'trigger_type' => $triggerType,
            'deal_value_at_stage' => $deal->value,
            'probability_at_stage' => $toStage->probability,
            'was_won_or_lost' => in_array($toStage->type, ['won', 'lost'], true),
        ]);
    }
}