<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContractRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function forClient(int $clientId): \Illuminate\Database\Eloquent\Collection;
}
