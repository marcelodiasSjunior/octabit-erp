<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DealSLAViolation;
use App\Repositories\Contracts\DealSLAViolationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DealSLAViolationRepository implements DealSLAViolationRepositoryInterface
{
    public function __construct(private readonly DealSLAViolation $model) {}

    public function findById(int $id): ?DealSLAViolation
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DealSLAViolation
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->latest()->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data): DealSLAViolation
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): DealSLAViolation
    {
        $violation = $this->findOrFail($id);
        $violation->update($data);
        return $violation->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function paginateFiltered(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = $this->model->query()->with(['deal.pipeline', 'deal.stage']);

        if (!empty($filters['pipeline_id'])) {
            $query->whereHas('deal', fn ($q) => $q->where('pipeline_id', (int) $filters['pipeline_id']));
        }

        if (!empty($filters['severity'])) {
            $query->where('severity', (string) $filters['severity']);
        }

        return $query->latest('due_at')->paginate($perPage)->withQueryString();
    }

    public function countUnresolved(): int
    {
        return $this->model->where('resolved', false)->count();
    }

    public function countBySeverity(string $severity, bool $resolved = false): int
    {
        return $this->model->where('resolved', $resolved)->where('severity', $severity)->count();
    }

    public function findExisting(int $dealId, int $slaId, string $type, bool $resolved = false): ?DealSLAViolation
    {
        return $this->model->query()
            ->where('deal_id', $dealId)
            ->where('sla_rule_id', $slaId)
            ->where('violation_type', $type)
            ->where('resolved', $resolved)
            ->first();
    }

    public function getUnresolvedEscalatable(\DateTimeInterface $beforeDate): Collection
    {
        return $this->model->query()
            ->where('resolved', false)
            ->whereNull('escalated_to')
            ->where('due_at', '<=', $beforeDate)
            ->get();
    }

    public function chunkUnresolvedEscalatable(\DateTimeInterface $beforeDate, callable $callback, int $chunkSize = 100): void
    {
        $this->model->query()
            ->where('resolved', false)
            ->whereNull('escalated_to')
            ->where('due_at', '<=', $beforeDate)
            ->chunkById($chunkSize, $callback);
    }
}
