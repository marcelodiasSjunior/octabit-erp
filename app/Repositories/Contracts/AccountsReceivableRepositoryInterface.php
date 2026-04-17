<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\AccountsReceivable;
use App\Enums\PaymentStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AccountsReceivableRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Mark a receivable as paid on the given date.
     */
    public function markAsPaid(int $id, \DateTimeInterface $paymentDate): AccountsReceivable;

    /**
     * Total receivable amount due this month (regardless of status).
     */
    public function totalDueThisMonth(): float;

    /**
     * Total amount paid this month (for dashboard revenue metric).
     */
    public function totalPaidThisMonth(): float;

    /**
     * Count entries by status.
     *
     * @return array<string, int>
     */
    public function countByStatus(): array;
}
