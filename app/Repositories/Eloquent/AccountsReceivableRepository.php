<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\AccountsReceivable;
use App\Enums\PaymentStatus;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountsReceivableRepository implements AccountsReceivableRepositoryInterface
{
    public function __construct(private readonly AccountsReceivable $model) {}

    public function findById(int $id): ?AccountsReceivable
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): AccountsReceivable
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->orderBy('due_date')->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('client')->orderBy('due_date')->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with('client');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['month']) && !empty($filters['year'])) {
            $query->whereMonth('due_date', $filters['month'])
                  ->whereYear('due_date', $filters['year']);
        }

        return $query->orderBy('due_date')->paginate($perPage)->withQueryString();
    }

    public function create(array $data): AccountsReceivable
    {
        // Always calculate status on creation
        $dueDate = new \DateTimeImmutable($data['due_date']);
        $data['status'] = PaymentStatus::calculate($dueDate, null)->value;

        return $this->model->create($data);
    }

    public function update(int $id, array $data): AccountsReceivable
    {
        $ar = $this->findOrFail($id);
        $ar->update($data);
        $ar->recalculateStatus();
        $ar->save();

        return $ar->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function markAsPaid(int $id, \DateTimeInterface $paymentDate): AccountsReceivable
    {
        $ar = $this->findOrFail($id);
        $ar->payment_date = $paymentDate;
        $ar->status       = PaymentStatus::Paid;
        $ar->save();

        return $ar->fresh();
    }

    public function totalDueThisMonth(): float
    {
        return (float) $this->model
            ->dueThisMonth()
            ->whereIn('status', [PaymentStatus::Pending->value, PaymentStatus::Overdue->value])
            ->sum('amount');
    }

    public function totalPaidThisMonth(): float
    {
        return (float) $this->model
            ->paid()
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');
    }

    public function countByStatus(): array
    {
        return $this->model
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}
