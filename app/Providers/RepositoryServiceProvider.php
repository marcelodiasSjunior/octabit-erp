<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Eloquent\AccountsReceivableRepository;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\EloquentDealRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Binds repository interfaces to their Eloquent implementations.
 * This is the only place where the concrete implementation is chosen —
 * the rest of the app depends on the interface, not the implementation (DIP).
 */
class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ClientRepositoryInterface::class             => ClientRepository::class,
        AccountsReceivableRepositoryInterface::class => AccountsReceivableRepository::class,
        DealRepositoryInterface::class               => EloquentDealRepository::class,
    ];
}
