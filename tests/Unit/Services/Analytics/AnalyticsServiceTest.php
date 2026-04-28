<?php

namespace Tests\Unit\Services\Analytics;

use App\Services\Analytics\AnalyticsService;
use App\Services\Analytics\Providers\RevenueChartProvider;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_revenue_provider_returns_correct_structure(): void
    {
        $provider = new RevenueChartProvider();
        $data = $provider->get();

        $this->assertArrayHasKey('labels', $data);
        $this->assertArrayHasKey('series', $data);
        $this->assertIsArray($data['labels']);
        $this->assertIsArray($data['series']);
    }
}
