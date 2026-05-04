<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    /**
     * Perfis (Roles) do usuário.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Permissões individuais (Sobrescritas).
     */
    public function individualPermissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
            ->withPivot('action');
    }

    /**
     * Verifica se o usuário tem uma permissão específica.
     * Segue a hierarquia: Individual > Perfil > MasterGlobal bypass.
     */
    public function hasPermissionTo(string $permissionSlug): bool
    {
        // 1. Master Global tem acesso irrestrito
        if ($this->isMasterGlobal()) {
            return true;
        }

        // 2. Cache das permissões para evitar queries repetitivas
        $cacheKey = "user_perms_{$this->id}";

        $permissions = Cache::remember($cacheKey, 3600, function () {
            return $this->getAllPermissions();
        });

        return in_array($permissionSlug, $permissions, true);
    }

    /**
     * Consolida todas as permissões efetivas do usuário.
     */
    public function getAllPermissions(): array
    {
        // A. Permissões dos Perfis (Roles)
        $rolePermissions = $this->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('slug')
            ->toArray();

        // B. Sobrescritas Individuais
        $overrides = $this->individualPermissions()->get();
        
        $granted = $overrides->where('pivot.action', 'grant')->pluck('slug')->toArray();
        $denied  = $overrides->where('pivot.action', 'deny')->pluck('slug')->toArray();

        // Lógica: (Base + Granted) - Denied
        $final = array_unique(array_merge($rolePermissions, $granted));
        return array_values(array_diff($final, $denied));
    }

    /**
     * Limpa o cache de permissões.
     */
    public function clearPermissionCache(): void
    {
        Cache::forget("user_perms_{$this->id}");
    }
}
