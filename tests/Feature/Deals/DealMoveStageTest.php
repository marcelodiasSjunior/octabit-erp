<?php

declare(strict_types=1);

use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\PipelineStage;

it('moves deal stage via ajax', function () {
    $pipeline = Pipeline::factory()->create();
    $stageA = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $stageB = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);

    $deal = Deal::factory()->create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stageA->id,
    ]);

    $this->actingAs(adminUser())
        ->patchJson(route('deals.move-stage', $deal), ['stage_id' => $stageB->id])
        ->assertOk()
        ->assertJson(['success' => true]);

    expect($deal->fresh()->stage_id)->toBe($stageB->id);
});
