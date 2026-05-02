<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentTagRepository implements TagRepositoryInterface
{
    public function __construct(private readonly Tag $model) {}

    public function findById(int $id): ?Tag
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Tag
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Tag
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Tag
    {
        $tag = $this->findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function paginate(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage);
    }

    public function allOrderedByName(): Collection
    {
        return $this->model->newQuery()->orderBy('name')->get();
    }

    public function findByName(string $name): ?Tag
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    public function firstOrCreate(array $attributes, array $values = []): Tag
    {
        return $this->model->newQuery()->firstOrCreate($attributes, $values);
    }
}
