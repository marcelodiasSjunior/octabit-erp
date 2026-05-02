<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DealActivity;
use App\Repositories\Contracts\DealActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DealActivityRepository implements DealActivityRepositoryInterface
{
    public function __construct(private readonly DealActivity $model) {}

    public function findById(int $id): ?DealActivity
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DealActivity
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

    public function create(array $data): DealActivity
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): DealActivity
    {
        $activity = $this->findOrFail($id);
        $activity->update($data);
        return $activity->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function findRecentActivity(int $dealId, string $title, int $hours): bool
    {
        return $this->model->query()
            ->where('deal_id', $dealId)
            ->where('title', $title)
            ->where('created_at', '>=', now()->subHours($hours))
            ->exists();
    }
}
