<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Client\CreateClientDTO;
use App\DTOs\Client\UpdateClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class ClientService
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function findOrFail(int $id): Client
    {
        return $this->repository->findOrFail($id);
    }

    public function create(CreateClientDTO $dto): Client
    {
        $client = $this->repository->create($dto->toArray());
        Cache::forget('dashboard.client_counts');
        return $client;
    }

    public function update(int $id, UpdateClientDTO $dto): Client
    {
        $client = $this->repository->update($id, $dto->toArray());
        Cache::forget('dashboard.client_counts');
        return $client;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
        Cache::forget('dashboard.client_counts');
    }

    /**
     * Count clients by status — used by dashboard.
     *
     * @return array<string, int>
     */
    public function countByStatus(): array
    {
        return $this->repository->countByStatus();
    }
}
