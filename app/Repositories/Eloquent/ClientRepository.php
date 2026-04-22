<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(private readonly Client $model) {}

    public function findById(int $id): ?Client
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Client
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('name')->paginate($perPage);
    }

    public function paginateFiltered(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        } elseif (($filters['segment'] ?? null) === 'leads') {
            $query->where('status', 'lead');
        } elseif (($filters['segment'] ?? null) === 'clients') {
            $query->where('status', '!=', 'lead');
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('company_name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('document', 'like', $search);
            });
        }

        return $query->orderBy('name')->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Client
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Client
    {
        $client = $this->findOrFail($id);
        $client->update($data);

        return $client->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function findByEmail(string $email): ?Client
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByDocument(string $document): ?Client
    {
        return $this->model->where('document', $document)->first();
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
