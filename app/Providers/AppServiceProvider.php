<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ContractRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Eloquent\AccountsPayableRepository;
use App\Repositories\Eloquent\AccountsReceivableRepository;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\ContractRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\QuoteRepository;
use App\Repositories\Eloquent\ServiceRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(AccountsReceivableRepositoryInterface::class, AccountsReceivableRepository::class);
        $this->app->bind(AccountsPayableRepositoryInterface::class, AccountsPayableRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(QuoteRepositoryInterface::class, QuoteRepository::class);
    }

    public function boot(): void
    {
        Gate::define('delete-client', fn (User $user) => $user->role->can('clients.delete'));
    }
}
