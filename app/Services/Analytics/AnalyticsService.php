<?php

namespace App\Services\Analytics;

use App\Services\Analytics\Providers\RevenueChartProvider;
use App\Services\Analytics\Providers\TagsDistributionChartProvider;

class AnalyticsService
{
    public function getDashboardCharts(): array
    {
        return [
            'revenue' => (new RevenueChartProvider())->get(),
            'tags_distribution' => (new TagsDistributionChartProvider())->get(),
        ];
    }
}
