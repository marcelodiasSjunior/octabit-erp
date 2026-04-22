<?php

declare(strict_types=1);

use App\Models\DealFollowupRule;
use App\Models\DealSLA;
use App\Models\Pipeline;
use App\Models\PipelineStage;

it('renders follow-up settings page', function () {
    $this->actingAs(adminUser())
        ->get(route('followups.settings.index'))
        ->assertOk()
        ->assertSeeText('Configurações de Follow-up');
});

it('creates sla and follow-up rule from settings', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);

    $this->actingAs(adminUser())
        ->post(route('followups.settings.slas.store'), [
            'pipeline_id' => $pipeline->id,
            'stage_id' => $stage->id,
            'name' => 'SLA Padrão Comercial',
            'response_sla_hours' => 24,
            'followup_interval_days' => 3,
            'escalation_threshold_days' => 2,
            'priority' => 10,
            'warning_hours_before' => 4,
            'active' => true,
        ])
        ->assertRedirect(route('followups.settings.index'));

    $sla = DealSLA::where('name', 'SLA Padrão Comercial')->first();

    expect($sla)->not->toBeNull();

    $this->actingAs(adminUser())
        ->post(route('followups.settings.rules.store'), [
            'pipeline_id' => $pipeline->id,
            'stage_id' => $stage->id,
            'deal_sla_id' => $sla->id,
            'name' => 'D-3 sem atividade',
            'trigger_type' => 'days_without_activity',
            'trigger_value' => '3',
            'action_type' => 'create_activity',
            'activity_type' => 'task',
            'order' => 1,
            'cooldown_hours' => 24,
            'only_if_no_recent_activity' => true,
            'active' => true,
        ])
        ->assertRedirect(route('followups.settings.index'));

    expect(DealFollowupRule::where('name', 'D-3 sem atividade')->exists())->toBeTrue();
});
