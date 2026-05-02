<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function allActive(): \Illuminate\Database\Eloquent\Collection;
    public function search(?string $query, int $limit = 50): \Illuminate\Database\Eloquent\Collection;
}
