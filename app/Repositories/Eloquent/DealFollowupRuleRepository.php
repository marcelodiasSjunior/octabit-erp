<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DealFollowupRule;
use App\Repositories\Contracts\DealFollowupRuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DealFollowupRuleRepository implements DealFollowupRuleRepositoryInterface
{
    public function __construct(private readonly DealFollowupRule $model) {}

    public function findById(int $id): ?DealFollowupRule
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DealFollowupRule
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data): DealFollowupRule
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): DealFollowupRule
    {
        $rule = $this->findOrFail($id);
        $rule->update($data);
        return $rule->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getAllOrdered(): Collection
    {
        return $this->model->with(['pipeline', 'stage', 'sla'])->ordered()->get();
    }

    public function getActiveForStage(int $pipelineId, int $stageId): Collection
    {
        return $this->model->query()
            ->active()
            ->forPipeline($pipelineId)
            ->forStage($stageId)
            ->ordered()
            ->get();
    }
}
