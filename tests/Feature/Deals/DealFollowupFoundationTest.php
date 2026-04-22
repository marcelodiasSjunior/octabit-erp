<?php

declare(strict_types=1);

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealFollowupRule;
use App\Models\DealSLA;
use App\Models\DealSLAViolation;
use App\Models\DealStageHistory;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use Illuminate\Support\Facades\Schema;

it('creates configurable follow-up foundation records', function () {
    expect(Schema::hasTable('deal_slas'))->toBeTrue()
        ->and(Schema::hasTable('deal_followup_rules'))->toBeTrue()
        ->and(Schema::hasTable('deal_sla_violations'))->toBeTrue()
        ->and(Schema::hasTable('deal_stage_history'))->toBeTrue();

    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create([
        'pipeline_id' => $pipeline->id,
        'position' => 1,
        'type' => 'open',
    ]);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
    ]);

    $sla = DealSLA::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'Primeiro contato',
        'response_sla_hours' => 24,
        'followup_interval_days' => 3,
        'active' => true,
        'priority' => 10,
        'warning_hours_before' => 4,
    ]);

    $rule = DealFollowupRule::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'deal_sla_id' => $sla->id,
        'name' => 'D-3 sem atividade',
        'trigger_type' => 'days_without_activity',
        'trigger_value' => '3',
        'action_type' => 'create_activity',
        'activity_type' => 'call',
        'active' => true,
        'order' => 1,
        'only_if_no_recent_activity' => true,
        'cooldown_hours' => 24,
    ]);

    $violation = DealSLAViolation::create([
        'deal_id' => $deal->id,
        'sla_rule_id' => $sla->id,
        'violation_type' => 'followup_missed',
        'due_at' => now()->subDay(),
        'severity' => 'warning',
    ]);

    $history = DealStageHistory::create([
        'deal_id' => $deal->id,
        'from_stage_id' => null,
        'to_stage_id' => $stage->id,
        'entered_at' => now()->subDays(2),
        'trigger_type' => 'manual',
        'deal_value_at_stage' => $deal->value,
        'probability_at_stage' => 25,
        'was_won_or_lost' => false,
    ]);

    expect($pipeline->slas()->count())->toBe(1)
        ->and($pipeline->followupRules()->count())->toBe(1)
        ->and($sla->rules()->count())->toBe(1)
        ->and($deal->slaViolations()->count())->toBe(1)
        ->and($deal->stageHistory()->count())->toBe(1)
        ->and($rule->sla?->is($sla))->toBeTrue()
        ->and($violation->deal?->is($deal))->toBeTrue()
        ->and($history->toStage?->is($stage))->toBeTrue();
});