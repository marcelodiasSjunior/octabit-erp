<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface DealSLARepositoryInterface extends BaseRepositoryInterface
{
    public function getAllOrdered(): \Illuminate\Database\Eloquent\Collection;
}
