<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(private readonly Service $model) {}

    public function findById(int $id): ?Service
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Service
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function allActive(): Collection
    {
        return $this->model->active()->orderBy('name')->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (isset($filters['active'])) {
            $query->where('active', (bool) $filters['active']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }

        return $query->orderBy('name')->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Service
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Service
    {
        $service = $this->findOrFail($id);
        $service->update($data);
        return $service->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function search(?string $query, int $limit = 50): Collection
    {
        return $this->model->newQuery()
            ->when($query, function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }
}
