<?php

declare(strict_types=1);

use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\DealSLA;
use App\Models\DealSLAViolation;
use App\Models\DealFollowupWebhook;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use App\Models\User;
use App\Notifications\DealFollowupAlertNotification;
use App\Services\DealSLAService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

it('sends notification and webhook when violation is created', function () {
    Notification::fake();
    Http::fake();

    $admin = adminUser();
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);

    DealSLA::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'SLA Base',
        'response_sla_hours' => 24,
        'followup_interval_days' => 3,
        'active' => true,
        'priority' => 10,
        'warning_hours_before' => 4,
    ]);

    DealFollowupWebhook::create([
        'name' => 'Webhook A',
        'event' => 'violation.created',
        'url' => 'https://example.com/hooks/followups',
        'secret' => 'abc123',
        'active' => true,
    ]);

    DealActivity::factory()->create([
        'deal_id' => $deal->id,
        'done' => false,
        'scheduled_at' => now()->subHours(36),
    ]);

    app(DealSLAService::class)->evaluateDeal($deal->fresh());

    Notification::assertSentTo($admin, DealFollowupAlertNotification::class);
    Http::assertSentCount(1);
});

it('escalates unresolved violations and notifies escalated user', function () {
    Notification::fake();
    Http::fake();

    $manager = User::factory()->create(['role' => \App\Enums\UserRole::Manager]);
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);

    $sla = DealSLA::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'SLA Base',
        'response_sla_hours' => 24,
        'followup_interval_days' => 3,
        'escalation_threshold_days' => 1,
        'active' => true,
        'priority' => 10,
        'warning_hours_before' => 4,
    ]);

    $violation = DealSLAViolation::create([
        'deal_id' => $deal->id,
        'sla_rule_id' => $sla->id,
        'violation_type' => 'response_timeout',
        'due_at' => now()->subDays(2),
        'severity' => 'warning',
        'resolved' => false,
    ]);

    DealFollowupWebhook::create([
        'name' => 'Webhook B',
        'event' => 'violation.escalated',
        'url' => 'https://example.com/hooks/escalation',
        'secret' => 'abc123',
        'active' => true,
    ]);

    app(DealSLAService::class)->processEscalations();

    $violation->refresh();

    expect($violation->escalated_to)->toBe($manager->id)
        ->and($violation->severity)->toBe('critical');

    Notification::assertSentTo($manager, DealFollowupAlertNotification::class);
    Http::assertSentCount(1);
});
