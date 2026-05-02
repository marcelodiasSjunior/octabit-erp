<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\PaymentStatus;
use App\Models\AccountsPayable;
use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountsPayableRepository implements AccountsPayableRepositoryInterface
{
    public function __construct(private readonly AccountsPayable $model) {}

    public function findById(int $id): ?AccountsPayable
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): AccountsPayable
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->orderBy('due_date')->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('due_date')->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('due_date', $filters['month'])
                  ->whereYear('due_date', $filters['year']);
        }

        return $query->orderBy('due_date')->paginate($perPage)->withQueryString();
    }

    public function markAsPaid(int $id, DateTimeImmutable $date): AccountsPayable
    {
        $payable = $this->findOrFail($id);
        $payable->update([
            'payment_date' => $date->format('Y-m-d'),
            'status'       => PaymentStatus::Paid->value,
        ]);
        return $payable->fresh();
    }

    public function totalPaidThisMonth(): float
    {
        return (float) $this->model
            ->where('status', PaymentStatus::Paid->value)
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
    }

    public function totalDueThisMonth(): float
    {
        return (float) $this->model
            ->whereNotIn('status', [PaymentStatus::Paid->value, PaymentStatus::Canceled->value])
            ->whereMonth('due_date', now()->month)
            ->whereYear('due_date', now()->year)
            ->sum('amount');
    }

    public function countByStatus(): array
    {
        return $this->model
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    public function create(array $data): AccountsPayable
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): AccountsPayable
    {
        $payable = $this->findOrFail($id);
        $payable->update($data);
        return $payable->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getFinancialData(string $startDate, string $endDate, ?string $status = null): Collection
    {
        $query = $this->model->newQuery()
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('due_date', [$startDate, $endDate])
                    ->orWhereBetween('payment_date', [$startDate, $endDate]);
            });

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function getMonthlyPaidTotal(string $startDate, string $endDate): array
    {
        return $this->model->where('status', PaymentStatus::Paid->value)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->selectRaw("DATE_FORMAT(due_date, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }
}
