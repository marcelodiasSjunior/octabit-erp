<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\DealSLAViolation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DealSLAViolationRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateFiltered(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function countUnresolved(): int;
    public function countBySeverity(string $severity, bool $resolved = false): int;
    public function findExisting(int $dealId, int $slaId, string $type, bool $resolved = false): ?DealSLAViolation;
    public function getUnresolvedEscalatable(\DateTimeInterface $beforeDate): \Illuminate\Database\Eloquent\Collection;
    public function chunkUnresolvedEscalatable(\DateTimeInterface $beforeDate, callable $callback, int $chunkSize = 100): void;
}
