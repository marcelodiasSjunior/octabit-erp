<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * List users for a specific company.
     */
    public function listUsersByCompany(int $companyId, int $perPage = 10): LengthAwarePaginator
    {
        return User::where('company_id', $companyId)
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Create a new user for a company.
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'role'       => $data['role'] ?? UserRole::User,
            'company_id' => $data['company_id'],
        ]);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, array $data): bool
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}
