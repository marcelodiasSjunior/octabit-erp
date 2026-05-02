<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Client\CreateClientDTO;
use App\DTOs\Client\UpdateClientDTO;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function() use ($dto) {
            $client = $this->repository->create($dto->toArray());
            if ($dto->tags) {
                $client->tags()->sync($dto->tags);
            }
            Cache::forget('dashboard.client_counts');
            return $client;
        });
    }

    public function update(int $id, UpdateClientDTO $dto): Client
    {
        return DB::transaction(function() use ($id, $dto) {
            $client = $this->repository->update($id, $dto->toArray());
            if ($dto->tags !== null) {
                $client->tags()->sync($dto->tags);
            }
            Cache::forget('dashboard.client_counts');
            return $client;
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function() use ($id) {
            $this->repository->delete($id);
            Cache::forget('dashboard.client_counts');
        });
    }

    /** Interaction Management */

    public function addInteraction(int $clientId, array $data, int $userId): \App\Models\ClientInteraction
    {
        return DB::transaction(function() use ($clientId, $data, $userId) {
            $client = $this->findOrFail($clientId);
            
            return $client->interactions()->create([
                ...$data,
                'user_id' => $userId,
            ]);
        });
    }

    public function deleteInteraction(int $clientId, int $interactionId): void
    {
        DB::transaction(function() use ($clientId, $interactionId) {
            $client = $this->findOrFail($clientId);
            $interaction = $client->interactions()->findOrFail($interactionId);
            $interaction.delete();
        });
    }

    /** Product & Service Mapping */

    public function addProduct(int $clientId, array $data): \App\Models\ClientProduct
    {
        return DB::transaction(function() use ($clientId, $data) {
            $client = $this->findOrFail($clientId);
            return $client->clientProducts()->create($data);
        });
    }

    public function removeProduct(int $clientId, int $mappingId): void
    {
        DB::transaction(function() use ($clientId, $mappingId) {
            $client = $this->findOrFail($clientId);
            $mapping = $client->clientProducts()->findOrFail($mappingId);
            $mapping->delete();
        });
    }

    public function addService(int $clientId, array $data): \App\Models\ClientService
    {
        return DB::transaction(function() use ($clientId, $data) {
            $client = $this->findOrFail($clientId);
            return $client->clientServices()->create($data);
        });
    }

    public function removeService(int $clientId, int $mappingId): void
    {
        DB::transaction(function() use ($clientId, $mappingId) {
            $client = $this->findOrFail($clientId);
            $mapping = $client->clientServices()->findOrFail($mappingId);
            $mapping->delete();
        });
    }

    /** Webhook & Restoration Helpers */

    public function findExistingLead(string $email, ?string $phone = null): ?Client
    {
        return $this->repository->findExistingLead($email, $phone);
    }

    public function restore(int $id): Client
    {
        $client = $this->repository->restore($id);
        Cache::forget('dashboard.client_counts');
        return $client;
    }

    public function syncTags(int $clientId, array $tagIds): void
    {
        $client = $this->findOrFail($clientId);
        $client->tags()->syncWithoutDetaching($tagIds);
    }

    public function searchClients(?string $query, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->searchByStatus(['active'], $query, $limit);
    }

    public function searchLeads(?string $query, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->searchByStatus(['lead'], $query, $limit);
    }

    public function searchAllEligible(?string $query, int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->searchByStatus(['lead', 'active'], $query, $limit);
    }

    /**
     * Get clients eligible for deals/contracts.
     */
    public function getEligibleForDeals(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getEligibleForDeals();
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
