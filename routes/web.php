<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Catalog\ServiceController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\ClientInteractionController;
use App\Http\Controllers\Client\ClientProductController;
use App\Http\Controllers\Client\ClientServiceController;
use App\Http\Controllers\Contract\ContractController;
use App\Http\Controllers\Deal\DealActivityController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Deal\FollowupDashboardController;
use App\Http\Controllers\Deal\FollowupSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Quote\QuoteController as WebQuoteController;
use App\Http\Controllers\Financial\AccountsPayableController;
use App\Http\Controllers\Financial\AccountsReceivableController;
use Illuminate\Support\Facades\Route;

// ── Auth routes ───────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ── Authenticated routes ──────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clients
    Route::get('leads', [ClientController::class, 'leads'])->name('leads.index');
    Route::get('leads/create', [ClientController::class, 'createLead'])->name('leads.create');
    Route::post('leads', [ClientController::class, 'storeLead'])->name('leads.store');
    Route::resource('clients', ClientController::class);

    // Deals / opportunities
    Route::resource('deals', DealController::class);
    Route::patch('deals/{id}/move-stage', [DealController::class, 'moveStage'])->name('deals.move-stage');
    Route::get('pipelines/{pipeline}/kanban', [DealController::class, 'kanban'])->name('deals.kanban');

    // Deal activities
    Route::post('deals/{deal}/activities', [DealActivityController::class, 'store'])->name('deals.activities.store');
    Route::patch('deals/{deal}/activities/{activity}/complete', [DealActivityController::class, 'complete'])->name('deals.activities.complete');
    Route::delete('deals/{deal}/activities/{activity}', [DealActivityController::class, 'destroy'])->name('deals.activities.destroy');

    // Follow-up settings and dashboard
    Route::get('followups/settings', [FollowupSettingsController::class, 'index'])->name('followups.settings.index');
    Route::post('followups/settings/slas', [FollowupSettingsController::class, 'storeSla'])->name('followups.settings.slas.store');
    Route::post('followups/settings/rules', [FollowupSettingsController::class, 'storeRule'])->name('followups.settings.rules.store');
    Route::get('followups/dashboard', [FollowupDashboardController::class, 'index'])->name('followups.dashboard.index');

    // CRM — Client sub-resources
    Route::post('clients/{client}/services',             [ClientServiceController::class, 'store'])->name('clients.services.store');
    Route::delete('clients/{client}/services/{cs}',      [ClientServiceController::class, 'destroy'])->name('clients.services.destroy');
    Route::post('clients/{client}/products',             [ClientProductController::class, 'store'])->name('clients.products.store');
    Route::delete('clients/{client}/products/{cp}',      [ClientProductController::class, 'destroy'])->name('clients.products.destroy');
    Route::post('clients/{client}/interactions',         [ClientInteractionController::class, 'store'])->name('clients.interactions.store');
    Route::delete('clients/{client}/interactions/{ci}',  [ClientInteractionController::class, 'destroy'])->name('clients.interactions.destroy');

    // Tags
    Route::resource('tags', \App\Http\Controllers\TagController::class);

    // Services catalog
    Route::resource('services', ServiceController::class);

    // Products catalog
    Route::resource('products', ProductController::class);

    // Quotes
    Route::resource('quotes', WebQuoteController::class);
    Route::patch('quotes/{id}/send',    [WebQuoteController::class, 'send'])->name('quotes.send');
    Route::patch('quotes/{id}/approve', [WebQuoteController::class, 'approve'])->name('quotes.approve');
    Route::patch('quotes/{id}/reject',  [WebQuoteController::class, 'reject'])->name('quotes.reject');

    // Contracts
    Route::resource('contracts', ContractController::class);
    Route::get('contracts/{id}/download', [ContractController::class, 'download'])->name('contracts.download');

    // Financial — Accounts Receivable
    Route::prefix('financial')->group(function () {
        Route::name('receivable.')->prefix('receivable')->group(function () {
            Route::get('/',               [AccountsReceivableController::class, 'index'])->name('index');
            Route::get('/create',         [AccountsReceivableController::class, 'create'])->name('create');
            Route::post('/',              [AccountsReceivableController::class, 'store'])->name('store');
            Route::patch('/{id}/paid',    [AccountsReceivableController::class, 'markAsPaid'])->name('mark-paid');
            Route::delete('/{id}',        [AccountsReceivableController::class, 'destroy'])->name('destroy');
        });

        // Financial — Accounts Payable
        Route::name('payable.')->prefix('payable')->group(function () {
            Route::get('/',               [AccountsPayableController::class, 'index'])->name('index');
            Route::get('/create',         [AccountsPayableController::class, 'create'])->name('create');
            Route::post('/',              [AccountsPayableController::class, 'store'])->name('store');
            Route::patch('/{id}/paid',    [AccountsPayableController::class, 'markAsPaid'])->name('mark-paid');
            Route::delete('/{id}',        [AccountsPayableController::class, 'destroy'])->name('destroy');
        });
    });
});

