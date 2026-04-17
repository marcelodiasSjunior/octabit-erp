<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ContractRepository implements ContractRepositoryInterface
{
    public function __construct(private readonly Contract $model) {}

    public function findById(int $id): ?Contract
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Contract
    {
        return $this->model->with('client')->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->with('client')->orderByDesc('created_at')->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('client')->orderByDesc('created_at')->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with('client')->newQuery();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->whereHas('client', fn ($q) => $q->where('name', 'like', $search)
                ->orWhere('company_name', 'like', $search));
        }

        return $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();
    }

    public function forClient(int $clientId): Collection
    {
        return $this->model->where('client_id', $clientId)->orderByDesc('created_at')->get();
    }

    public function create(array $data): Contract
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Contract
    {
        $contract = $this->findOrFail($id);
        $contract->update($data);
        return $contract->fresh('client');
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }
}
