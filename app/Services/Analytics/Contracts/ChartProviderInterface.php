<?php

namespace App\Services\Analytics\Contracts;

interface ChartProviderInterface
{
    /**
     * Get data formatted for charts (ApexCharts pattern).
     * 
     * @return array{labels: array, series: array}
     */
    public function get(): array;
}
