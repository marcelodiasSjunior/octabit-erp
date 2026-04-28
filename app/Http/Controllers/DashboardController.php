<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Analytics\AnalyticsService;
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
        private readonly AnalyticsService $analyticsService,
    ) {}

    public function index(): View
    {
        $user = auth()->user();
        
        // Padrão de layout se o usuário não personalizou
        $defaultLayout = [
            ['id' => 'stat-cards',      'visible' => true, 'order' => 1],
            ['id' => 'crm-stat-cards',  'visible' => true, 'order' => 2],
            ['id' => 'revenue-chart',   'visible' => true, 'order' => 3],
            ['id' => 'status-and-actions','visible' => true, 'order' => 4],
        ];

        $layout = $user->dashboard_layout ?? $defaultLayout;
        
        // Sort by order
        usort($layout, fn($a, $b) => $a['order'] <=> $b['order']);

        $clientCounts = Cache::remember('dashboard.client_counts', 300, fn () =>
            $this->clientService->countByStatus()
        );

        $financialMetrics = Cache::remember('dashboard.financial_metrics', 300, fn () =>
            $this->financialService->getDashboardMetrics()
        );

        $openDeals        = $this->dealService->countOpen();
        $wonDealsThisMonth = $this->dealService->countWonThisMonth();
        $weightedPipeline  = $this->dealService->weightedPipeline();

        $charts = $this->analyticsService->getDashboardCharts();

        return view('dashboard.index', [
            'activeClients'      => $clientCounts['active']    ?? 0,
            'totalLeads'         => $clientCounts['lead']       ?? 0,
            'totalPaidThisMonth' => $financialMetrics['total_paid_this_month'],
            'totalDueThisMonth'  => $financialMetrics['total_due_this_month'],
            'receivableByStatus' => $financialMetrics['receivable_by_status'],
            'openDeals'          => $openDeals,
            'wonDealsThisMonth'  => $wonDealsThisMonth,
            'weightedPipeline'   => $weightedPipeline,
            'charts'             => $charts,
            'layout'             => $layout,
        ]);
    }

    public function updateLayout(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'layout' => 'required|array'
        ]);

        auth()->user()->update([
            'dashboard_layout' => $request->layout
        ]);

        return response()->json(['success' => true]);
    }
}
