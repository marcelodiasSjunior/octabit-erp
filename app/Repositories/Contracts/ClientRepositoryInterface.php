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

    /**
     * Count clients grouped by status (for dashboard).
     *
     * @return array<string, int>
     */
    public function countByStatus(): array;
}
