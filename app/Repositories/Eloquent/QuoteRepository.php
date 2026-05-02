<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Quote;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class QuoteRepository implements QuoteRepositoryInterface
{
    public function __construct(private readonly Quote $model) {}

    public function findById(int $id): ?Quote
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Quote
    {
        return $this->model->with(['client', 'items'])->findOrFail($id);
    }

    public function findWithItemsOrFail(int $id): Quote
    {
        return $this->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model
            ->with('client')
            ->orderByDesc('created_at')
            ->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('client')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with('client')->newQuery();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->whereHas('client', fn ($q) => $q->where('name', 'like', $search)
                ->orWhere('company_name', 'like', $search));
        }

        return $query
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Quote
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Quote
    {
        $quote = $this->findOrFail($id);
        $quote->update($data);

        return $quote->fresh(['client', 'items']);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getQuotesInRange(string $startDate, string $endDate, ?int $clientId = null): Collection
    {
        $query = $this->model->with('client')
            ->whereBetween('created_at', [
                \Carbon\Carbon::parse($startDate)->startOfDay(),
                \Carbon\Carbon::parse($endDate)->endOfDay()
            ]);

        if ($clientId) {
            $query->where('client_id', $clientId);
        }

        return $query->get();
    }
}
