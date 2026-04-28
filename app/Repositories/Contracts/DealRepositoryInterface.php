<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Deal;

interface DealRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Count open deals.
     */
    public function countOpen(): int;

    /**
     * Count won deals in the current month.
     */
    public function countWonThisMonth(): int;

    /**
     * Get weighted pipeline sum.
     */
    public function weightedPipeline(): float;
}
