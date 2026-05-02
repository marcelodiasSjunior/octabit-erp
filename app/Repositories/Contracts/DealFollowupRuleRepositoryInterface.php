<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface DealFollowupRuleRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;
    public function getActiveForStage(int $pipelineId, int $stageId): \Illuminate\Database\Eloquent\Collection;
}
