<?php

declare(strict_types=1);

use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use App\Enums\DealStatus;

// ── Dashboard CRM metrics ─────────────────────────────────────────

it('dashboard exibe contagem de deals por status', function () {
    $pipeline = Pipeline::factory()->create();
    $openStage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);
    $wonStage  = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'won']);

    Deal::factory()->count(3)->create(['pipeline_id' => $pipeline->id, 'stage_id' => $openStage->id, 'status' => DealStatus::Open]);
    Deal::factory()->count(2)->create(['pipeline_id' => $pipeline->id, 'stage_id' => $wonStage->id,  'status' => DealStatus::Won, 'closed_at' => now()]);

    $this->actingAs(adminUser())
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('openDeals', 3)
        ->assertViewHas('wonDealsThisMonth', 2);
});

it('dashboard exibe valor total ponderado do pipeline', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create([
        'pipeline_id' => $pipeline->id,
        'type'        => 'open',
        'probability' => 50,
    ]);

    Deal::factory()->count(2)->create([
        'pipeline_id' => $pipeline->id,
        'stage_id'    => $stage->id,
        'status'      => DealStatus::Open,
        'value'       => 10000,
    ]);

    $this->actingAs(adminUser())
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHas('weightedPipeline', 10000.0);  // 2 * 10000 * 50% = 10000
});
