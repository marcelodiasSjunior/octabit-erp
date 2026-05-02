<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Pipeline;
use App\Repositories\Contracts\PipelineRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PipelineRepository implements PipelineRepositoryInterface
{
    public function __construct(private readonly Pipeline $model) {}

    public function findById(int $id): ?Pipeline
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Pipeline
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Pipeline
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Pipeline
    {
        $pipeline = $this->findOrFail($id);
        $pipeline->update($data);
        return $pipeline;
    }

    public function delete(int $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    public function getActiveWithStages(): Collection
    {
        return $this->model->newQuery()
            ->where('active', true)
            ->with(['stages' => fn ($q) => $q->where('active', true)->orderBy('position')])
            ->orderBy('name')
            ->get();
    }
}
