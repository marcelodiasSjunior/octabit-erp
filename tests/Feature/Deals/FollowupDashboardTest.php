<?php

declare(strict_types=1);

use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealSLA;
use App\Models\DealSLAViolation;
use App\Models\Pipeline;
use App\Models\PipelineStage;

it('renders follow-up dashboard with violation metrics and filters', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create(['name' => 'Inbound']);
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'name' => 'Contato Feito']);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);

    $sla = DealSLA::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'SLA Inbound',
        'response_sla_hours' => 24,
        'followup_interval_days' => 3,
        'active' => true,
        'priority' => 10,
        'warning_hours_before' => 4,
    ]);

    DealSLAViolation::create([
        'deal_id' => $deal->id,
        'sla_rule_id' => $sla->id,
        'violation_type' => 'response_timeout',
        'due_at' => now()->subDay(),
        'severity' => 'critical',
        'resolved' => false,
    ]);

    $this->actingAs(adminUser())
        ->get(route('followups.dashboard.index', ['pipeline_id' => $pipeline->id, 'severity' => 'critical']))
        ->assertOk()
        ->assertSeeText('Dashboard de Follow-up')
        ->assertSeeText('Inbound')
        ->assertSeeText('critical');
});
