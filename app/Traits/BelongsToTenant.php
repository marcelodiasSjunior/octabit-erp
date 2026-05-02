<?php

namespace App\Traits;

use App\Services\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model) {
            $tenantManager = app(TenantManager::class);
            if ($tenantManager->hasTenant() && !$model->company_id) {
                $model->company_id = $tenantManager->getCompanyId();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantManager = app(TenantManager::class);
            
            if ($tenantManager->hasTenant()) {
                $user = auth()->user();
                if (!$user || $user->role->value !== 'master_global') {
                    $builder->where($builder->getQuery()->from . '.company_id', $tenantManager->getCompanyId());
                }
            }
        });
    }
}
