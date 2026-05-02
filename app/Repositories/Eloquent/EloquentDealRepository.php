<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\DealStatus;
use App\Models\Deal;
use App\Repositories\Contracts\DealRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentDealRepository implements DealRepositoryInterface
{
    public function __construct(private readonly Deal $model) {}

    public function findById(int $id): ?Deal
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Deal
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->latest()->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['client', 'pipeline', 'stage'])->latest()->paginate($perPage);
    }

    public function create(array $data): Deal
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Deal
    {
        $deal = $this->findOrFail($id);
        $deal->update($data);
        return $deal->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function countOpen(): int
    {
        return $this->model->where('status', DealStatus::Open)->count();
    }

    public function countWonThisMonth(): int
    {
        return $this->model->where('status', DealStatus::Won)
            ->whereMonth('closed_at', now()->month)
            ->whereYear('closed_at', now()->year)
            ->count();
    }

    public function weightedPipeline(): float
    {
        return (float) $this->model->join('pipeline_stages', 'pipeline_stages.id', '=', 'deals.stage_id')
            ->where('deals.status', DealStatus::Open)
            ->whereNull('deals.deleted_at')
            ->sum(DB::raw('deals.value * pipeline_stages.probability / 100'));
    }

    public function chunkOpenDeals(callable $callback, int $chunkSize = 100): void
    {
        $this->model->query()
            ->where('status', DealStatus::Open->value)
            ->chunkById($chunkSize, $callback);
    }
}
