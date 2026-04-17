<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\AccountsPayable;
use DateTimeImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountsPayableRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function markAsPaid(int $id, DateTimeImmutable $date): AccountsPayable;
    public function totalPaidThisMonth(): float;
    public function totalDueThisMonth(): float;
    public function countByStatus(): array;
}
