<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\ContractRepositoryInterface;
use App\Repositories\Contracts\DealActivityRepositoryInterface;
use App\Repositories\Contracts\DealFollowupRuleRepositoryInterface;
use App\Repositories\Contracts\DealFollowupWebhookRepositoryInterface;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Contracts\DealSLARepositoryInterface;
use App\Repositories\Contracts\DealSLAViolationRepositoryInterface;
use App\Repositories\Contracts\PipelineRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\AccountsPayableRepository;
use App\Repositories\Eloquent\AccountsReceivableRepository;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\ContractRepository;
use App\Repositories\Eloquent\DealActivityRepository;
use App\Repositories\Eloquent\DealFollowupRuleRepository;
use App\Repositories\Eloquent\DealFollowupWebhookRepository;
use App\Repositories\Eloquent\DealSLARepository;
use App\Repositories\Eloquent\DealSLAViolationRepository;
use App\Repositories\Eloquent\EloquentDealRepository;
use App\Repositories\Eloquent\EloquentTagRepository;
use App\Repositories\Eloquent\PipelineRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\QuoteRepository;
use App\Repositories\Eloquent\ServiceRepository;
use App\Repositories\Eloquent\UserRepository;
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
        AccountsPayableRepositoryInterface::class    => AccountsPayableRepository::class,
        ContractRepositoryInterface::class           => ContractRepository::class,
        DealRepositoryInterface::class               => EloquentDealRepository::class,
        PipelineRepositoryInterface::class           => PipelineRepository::class,
        TagRepositoryInterface::class                => EloquentTagRepository::class,
        ProductRepositoryInterface::class            => ProductRepository::class,
        QuoteRepositoryInterface::class              => QuoteRepository::class,
        ServiceRepositoryInterface::class            => ServiceRepository::class,
        DealSLAViolationRepositoryInterface::class   => DealSLAViolationRepository::class,
        DealSLARepositoryInterface::class            => DealSLARepository::class,
        DealFollowupRuleRepositoryInterface::class   => DealFollowupRuleRepository::class,
        DealActivityRepositoryInterface::class       => DealActivityRepository::class,
        DealFollowupWebhookRepositoryInterface::class => DealFollowupWebhookRepository::class,
        UserRepositoryInterface::class               => UserRepository::class,
    ];
}
