<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\DealSLA;
use App\Repositories\Contracts\DealSLARepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DealSLARepository implements DealSLARepositoryInterface
{
    public function __construct(private readonly DealSLA $model) {}

    public function findById(int $id): ?DealSLA
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): DealSLA
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

    public function create(array $data): DealSLA
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): DealSLA
    {
        $sla = $this->findOrFail($id);
        $sla->update($data);
        return $sla->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getAllOrdered(): Collection
    {
        return $this->model->with(['pipeline', 'stage'])->orderByDesc('priority')->get();
    }
}
