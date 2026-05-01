<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Tag;
use App\Services\Analytics\Providers\TagsDistributionChartProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTagChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_distribution_chart_excludes_soft_deleted_leads(): void
    {
        $tag = Tag::create(['name' => 'Important', 'color' => 'red']);
        
        // Active lead with tag
        $client1 = Client::factory()->create();
        $client1->tags()->attach($tag->id);

        // Soft-deleted lead with same tag
        $client2 = Client::factory()->create();
        $client2->tags()->attach($tag->id);
        $client2->delete();

        $provider = new TagsDistributionChartProvider();
        $result = $provider->get();

        // The count should be 1, not 2
        $this->assertEquals(['Important'], $result['labels']);
        $this->assertEquals([1], $result['series']);
    }
}
