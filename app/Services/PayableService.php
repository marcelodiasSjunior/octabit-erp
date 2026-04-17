<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\AccountsPayable;
use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

final class PayableService
{
    public function __construct(
        private readonly AccountsPayableRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function findOrFail(int $id): AccountsPayable
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): AccountsPayable
    {
        $data['status'] = PaymentStatus::Pending->value;
        $record = $this->repository->create($data);
        Cache::forget('dashboard.financial_metrics');
        return $record;
    }

    public function markAsPaid(int $id, string $paymentDate): AccountsPayable
    {
        $date   = new \DateTimeImmutable($paymentDate);
        $record = $this->repository->markAsPaid($id, $date);
        Cache::forget('dashboard.financial_metrics');
        return $record;
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
        Cache::forget('dashboard.financial_metrics');
    }
}
