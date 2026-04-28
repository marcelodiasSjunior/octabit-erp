<?php

namespace App\Services\Analytics;

use App\Services\Analytics\Providers\RevenueChartProvider;

class AnalyticsService
{
    public function getDashboardCharts(): array
    {
        return [
            'revenue' => (new RevenueChartProvider())->get(),
            // Future providers will be added here
        ];
    }
}
