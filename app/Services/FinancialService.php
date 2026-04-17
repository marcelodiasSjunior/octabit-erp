<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AccountsReceivable;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class FinancialService
{
    public function __construct(
        private readonly AccountsReceivableRepositoryInterface $receivableRepo
    ) {}

    public function listReceivable(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->receivableRepo->paginateFiltered($filters, $perPage);
    }

    public function createReceivable(array $data): AccountsReceivable
    {
        $record = $this->receivableRepo->create($data);
        Cache::forget('dashboard.financial_metrics');
        return $record;
    }

    public function markReceivableAsPaid(int $id, string $paymentDate): AccountsReceivable
    {
        $date   = new \DateTimeImmutable($paymentDate);
        $record = $this->receivableRepo->markAsPaid($id, $date);
        Cache::forget('dashboard.financial_metrics');
        return $record;
    }

    public function findReceivableOrFail(int $id): AccountsReceivable
    {
        return $this->receivableRepo->findOrFail($id);
    }

    public function deleteReceivable(int $id): void
    {
        $this->receivableRepo->delete($id);
        Cache::forget('dashboard.financial_metrics');
    }

    /**
     * Dashboard metrics.
     */
    public function getDashboardMetrics(): array
    {
        return [
            'total_paid_this_month' => $this->receivableRepo->totalPaidThisMonth(),
            'total_due_this_month'  => $this->receivableRepo->totalDueThisMonth(),
            'receivable_by_status'  => $this->receivableRepo->countByStatus(),
        ];
    }
}
