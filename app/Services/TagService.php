<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

final class TagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository
    ) {}

    public function list(): Collection
    {
        return $this->repository->allOrderedByName();
    }

    public function findOrFail(int $id): Tag
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): Tag
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->repository->create($data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function firstOrCreate(string $name, array $extra = []): Tag
    {
        return $this->repository->firstOrCreate(
            ['name' => $name],
            array_merge(['slug' => Str::slug($name)], $extra)
        );
    }
}
