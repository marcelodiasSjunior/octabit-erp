<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface DealActivityRepositoryInterface extends BaseRepositoryInterface
{
    public function findRecentActivity(int $dealId, string $title, int $hours): bool;
}
