<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Services\DealService;
use App\Services\FinancialService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __construct(
        private readonly ClientService    $clientService,
        private readonly FinancialService $financialService,
        private readonly DealService      $dealService,
    ) {}

    public function index(): View
    {
        $clientCounts = Cache::remember('dashboard.client_counts', 300, fn () =>
            $this->clientService->countByStatus()
        );

        $financialMetrics = Cache::remember('dashboard.financial_metrics', 300, fn () =>
            $this->financialService->getDashboardMetrics()
        );

        $openDeals        = $this->dealService->countOpen();
        $wonDealsThisMonth = $this->dealService->countWonThisMonth();
        $weightedPipeline  = $this->dealService->weightedPipeline();

        return view('dashboard.index', [
            'activeClients'      => $clientCounts['active']    ?? 0,
            'totalLeads'         => $clientCounts['lead']       ?? 0,
            'totalPaidThisMonth' => $financialMetrics['total_paid_this_month'],
            'totalDueThisMonth'  => $financialMetrics['total_due_this_month'],
            'receivableByStatus' => $financialMetrics['receivable_by_status'],
            'openDeals'          => $openDeals,
            'wonDealsThisMonth'  => $wonDealsThisMonth,
            'weightedPipeline'   => $weightedPipeline,
        ]);
    }
}
