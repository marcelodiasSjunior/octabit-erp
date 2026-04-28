<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_dashboard_layout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $newLayout = [
            ['id' => 'revenue-chart', 'visible' => true, 'order' => 1],
            ['id' => 'stat-cards', 'visible' => true, 'order' => 2],
        ];

        $response = $this->postJson(route('dashboard.update-layout'), [
            'layout' => $newLayout
        ]);

        $response->assertStatus(200);
        $this->assertEquals($newLayout, $user->fresh()->dashboard_layout);
    }

    public function test_dashboard_uses_default_layout_when_none_saved(): void
    {
        $user = User::factory()->create(['dashboard_layout' => null]);
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('layout');
        
        $layout = $response->viewData('layout');
        $this->assertEquals('stat-cards', $layout[0]['id']);
    }
}
