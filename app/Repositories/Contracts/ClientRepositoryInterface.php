<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Client;
use App\Enums\ClientStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Paginate clients with optional filters.
     *
     * @param array{status?: string, search?: string} $filters
     */
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByEmail(string $email): ?Client;

    public function findByDocument(string $document): ?Client;

    public function findExistingLead(string $email, ?string $phone = null): ?Client;

    public function restore(int $id): Client;

    public function searchByStatus(array $statuses, ?string $query, int $limit = 50): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get clients eligible for deals (Leads or Active).
     */
    public function getEligibleForDeals(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Count clients grouped by status (for dashboard).
     *
     * @return array<string, int>
     */
    public function countByStatus(): array;
}
