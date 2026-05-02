<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    public function allOrderedByName(): Collection;
    public function findByName(string $name): ?Tag;
    public function firstOrCreate(array $attributes, array $values = []): Tag;
}
