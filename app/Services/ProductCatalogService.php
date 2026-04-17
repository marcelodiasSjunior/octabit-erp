<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class ProductCatalogService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function allActive(): Collection
    {
        return $this->repository->allActive();
    }

    public function findOrFail(int $id): Product
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Product
    {
        $data['active'] = $data['active'] ?? true;
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $data['active'] = isset($data['active']) ? (bool) $data['active'] : false;
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
