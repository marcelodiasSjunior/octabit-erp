<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DealFollowupWebhook;
use App\Repositories\Contracts\DealFollowupWebhookRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DealFollowupWebhookRepository implements DealFollowupWebhookRepositoryInterface
{
    public function __construct(private readonly DealFollowupWebhook $model) {}

    public function findById(int $id): ?DealFollowupWebhook
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DealFollowupWebhook
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

    public function create(array $data): DealFollowupWebhook
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): DealFollowupWebhook
    {
        $webhook = $this->findOrFail($id);
        $webhook->update($data);
        return $webhook->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getActiveByEvent(string $event): Collection
    {
        return $this->model->query()->active()->where('event', $event)->get();
    }
}
