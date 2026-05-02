<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Pipeline;
use App\Repositories\Contracts\PipelineRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class PipelineService
{
    public function __construct(
        private readonly PipelineRepositoryInterface $repository
    ) {}

    public function findOrFail(int $id): Pipeline
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Get all active pipelines with their stages.
     */
    public function getActiveWithStages(): Collection
    {
        return $this->repository->getActiveWithStages();
    }
}
