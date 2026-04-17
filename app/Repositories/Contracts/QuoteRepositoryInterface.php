<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Quote;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface QuoteRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array{status?: string, search?: string, client_id?: int} $filters
     */
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findWithItemsOrFail(int $id): Quote;
}
