<?php

declare(strict_types=1);

use App\Enums\DealActivityType;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\Pipeline;
use App\Models\PipelineStage;

// ── Create ────────────────────────────────────────────────────────

it('creates a deal activity', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $this->actingAs(adminUser())
        ->post(route('deals.activities.store', $deal), [
            'type'         => DealActivityType::Call->value,
            'title'        => 'Ligacao de Follow-up',
            'scheduled_at' => now()->addDay()->toDateTimeString(),
            'notes'        => 'Verificar interesse no plano anual',
        ])
        ->assertRedirect(route('deals.show', $deal->id));

    expect(DealActivity::where('deal_id', $deal->id)->where('title', 'Ligacao de Follow-up')->exists())->toBeTrue();
});

it('validates required fields when creating activity', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $this->actingAs(adminUser())
        ->post(route('deals.activities.store', $deal), [])
        ->assertSessionHasErrors(['type', 'title', 'scheduled_at']);
});

// ── Mark as done ──────────────────────────────────────────────────

it('marks a deal activity as done', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $activity = DealActivity::factory()->create([
        'deal_id'      => $deal->id,
        'done'         => false,
        'completed_at' => null,
    ]);

    $this->actingAs(adminUser())
        ->patch(route('deals.activities.complete', [$deal, $activity]))
        ->assertRedirect(route('deals.show', $deal->id));

    $activity->refresh();

    expect($activity->done)->toBeTrue()
        ->and($activity->completed_at)->not->toBeNull();
});

// ── Delete ────────────────────────────────────────────────────────

it('deletes a deal activity', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $activity = DealActivity::factory()->create(['deal_id' => $deal->id]);

    $this->actingAs(adminUser())
        ->delete(route('deals.activities.destroy', [$deal, $activity]))
        ->assertRedirect(route('deals.show', $deal->id));

    expect(DealActivity::find($activity->id))->toBeNull();
});

// ── SLA alert: overdue activities ────────────────────────────────

it('lists overdue activities (scheduled_at in the past and not done)', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $overdue = DealActivity::factory()->create([
        'deal_id'      => $deal->id,
        'done'         => false,
        'scheduled_at' => now()->subDays(2),
    ]);

    DealActivity::factory()->create([
        'deal_id'      => $deal->id,
        'done'         => false,
        'scheduled_at' => now()->addDay(),
    ]);

    $overdueActivities = DealActivity::overdue()->get();

    expect($overdueActivities)->toHaveCount(1)
        ->and($overdueActivities->first()->id)->toBe($overdue->id);
});
