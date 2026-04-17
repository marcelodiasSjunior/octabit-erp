<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ContractStatus;
use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ContractService
{
    public function __construct(
        private readonly ContractRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function findOrFail(int $id): Contract
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Contract
    {
        $data['status'] = $data['status'] ?? ContractStatus::Draft->value;
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Contract
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
