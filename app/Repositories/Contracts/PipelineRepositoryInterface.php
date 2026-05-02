<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Collection;

interface PipelineRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active pipelines with their active stages.
     */
    public function getActiveWithStages(): Collection;
}
