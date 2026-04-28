<?php

namespace App\Services\Analytics\Providers;

use App\Services\Analytics\Contracts\ChartProviderInterface;
use App\Models\AccountsReceivable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueChartProvider implements ChartProviderInterface
{
    public function get(): array
    {
        $data = AccountsReceivable::selectRaw("
                DATE_FORMAT(due_date, '%Y-%m') as month,
                SUM(amount) as total
            ")
            ->where('status', 'paid')
            ->where('due_date', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $seriesData = [];

        // Fill gaps in months if any
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('M/y');
            
            $match = $data->firstWhere('month', $month);
            $seriesData[] = $match ? (float) $match->total : 0;
        }

        return [
            'labels' => $labels,
            'series' => [
                [
                    'name' => 'Receita',
                    'data' => $seriesData
                ]
            ]
        ];
    }
}
