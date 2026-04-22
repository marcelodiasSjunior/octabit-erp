<?php

declare(strict_types=1);

use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\DealFollowupRule;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use Illuminate\Support\Facades\Artisan;

it('processes open deals and generates follow-up activities via command', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);

    $openDeal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);
    $openDeal->forceFill(['updated_at' => now()->subDays(5)])->saveQuietly();

    $closedDeal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Won,
        'closed_at' => now()->subDay(),
    ]);
    $closedDeal->forceFill(['updated_at' => now()->subDays(5)])->saveQuietly();

    DealFollowupRule::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'Regra D-3',
        'trigger_type' => 'days_without_activity',
        'trigger_value' => '3',
        'action_type' => 'create_activity',
        'activity_type' => 'task',
        'active' => true,
        'order' => 1,
        'only_if_no_recent_activity' => true,
        'cooldown_hours' => 24,
    ]);

    $exitCode = Artisan::call('deals:process-followups');

    expect($exitCode)->toBe(0)
        ->and(DealActivity::where('deal_id', $openDeal->id)->where('type', 'task')->count())->toBe(1)
        ->and(DealActivity::where('deal_id', $closedDeal->id)->count())->toBe(0);
});
