<?php

declare(strict_types=1);

use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\PipelineStage;

// ── Kanban view ───────────────────────────────────────────────────

it('exibe kanban do pipeline com colunas por etapa', function () {
    $pipeline = Pipeline::factory()->create(['name' => 'Vendas B2B']);
    $stageA = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'name' => 'Qualificacao', 'position' => 1]);
    $stageB = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'name' => 'Proposta', 'position' => 2]);

    Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stageA->id, 'title' => 'Deal Alpha']);
    Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stageB->id, 'title' => 'Deal Beta']);

    $this->actingAs(adminUser())
        ->get(route('deals.kanban', $pipeline))
        ->assertOk()
        ->assertViewIs('deals.kanban')
        ->assertSeeText('Qualificacao')
        ->assertSeeText('Proposta')
        ->assertSeeText('Deal Alpha')
        ->assertSeeText('Deal Beta');
});

it('move deal to new stage via kanban ajax request', function () {
    $pipeline = Pipeline::factory()->create();
    $stageA = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open', 'probability' => 20]);
    $stageB = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open', 'probability' => 60]);

    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stageA->id]);

    $this->actingAs(adminUser())
        ->patchJson(route('deals.move-stage', $deal), ['stage_id' => $stageB->id])
        ->assertOk()
        ->assertJson(['success' => true]);

    expect($deal->fresh()->stage_id)->toBe($stageB->id);
});

it('nao permite mover deal para etapa de outro pipeline via kanban', function () {
    $pipelineA = Pipeline::factory()->create();
    $pipelineB = Pipeline::factory()->create();

    $stageA = PipelineStage::factory()->create(['pipeline_id' => $pipelineA->id]);
    $stageB = PipelineStage::factory()->create(['pipeline_id' => $pipelineB->id]);

    $deal = Deal::factory()->create(['pipeline_id' => $pipelineA->id, 'stage_id' => $stageA->id]);

    $this->actingAs(adminUser())
        ->patchJson(route('deals.move-stage', $deal), ['stage_id' => $stageB->id])
        ->assertUnprocessable();
});
