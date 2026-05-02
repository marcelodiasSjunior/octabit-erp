<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findFirstByRole(string $role): ?User;
    public function getByRole(string $role): \Illuminate\Database\Eloquent\Collection;
}
