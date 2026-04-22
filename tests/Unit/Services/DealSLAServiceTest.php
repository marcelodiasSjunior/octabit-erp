<?php

declare(strict_types=1);

use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\DealFollowupRule;
use App\Models\DealSLA;
use App\Models\DealSLAViolation;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use App\Notifications\DealFollowupAlertNotification;
use App\Services\DealSLAService;
use Illuminate\Support\Facades\Notification;

it('creates sla violation when response window is exceeded', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);
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

    DealActivity::factory()->create([
        'deal_id' => $deal->id,
        'done' => false,
        'scheduled_at' => now()->subHours(30),
    ]);

    app(DealSLAService::class)->evaluateDeal($deal->fresh());

    expect(DealSLAViolation::where('deal_id', $deal->id)->count())->toBe(1)
        ->and(DealSLAViolation::where('deal_id', $deal->id)->first()?->violation_type)->toBe('response_timeout');
});

it('does not duplicate unresolved violation for same sla rule', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);
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
        'active' => true,
        'priority' => 10,
        'warning_hours_before' => 4,
    ]);

    DealActivity::factory()->create([
        'deal_id' => $deal->id,
        'done' => false,
        'scheduled_at' => now()->subHours(40),
    ]);

    $service = app(DealSLAService::class);
    $service->evaluateDeal($deal->fresh());
    $service->evaluateDeal($deal->fresh());

    expect(DealSLAViolation::where('deal_id', $deal->id)
        ->where('sla_rule_id', $sla->id)
        ->where('resolved', false)
        ->count())->toBe(1);
});

it('creates automated follow-up activity from dynamic rule', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);

    DealFollowupRule::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'Regra D-3',
        'trigger_type' => 'days_without_activity',
        'trigger_value' => '3',
        'action_type' => 'create_activity',
        'activity_type' => 'call',
        'active' => true,
        'order' => 1,
        'only_if_no_recent_activity' => true,
        'cooldown_hours' => 24,
    ]);

    $deal->forceFill(['updated_at' => now()->subDays(4)])->saveQuietly();

    app(DealSLAService::class)->evaluateDeal($deal->fresh());

    expect(DealActivity::where('deal_id', $deal->id)
        ->where('type', 'call')
        ->where('title', 'like', 'Follow-up automático:%')
        ->count())->toBe(1);
});

it('sends dynamic email notification when rule action is send_email', function () {
    Notification::fake();

    $admin = adminUser();
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id, 'type' => 'open']);
    $deal = Deal::factory()->create([
        'client_id' => $client->id,
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'status' => DealStatus::Open,
    ]);

    DealFollowupRule::create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $stage->id,
        'name' => 'Email D-3',
        'trigger_type' => 'days_without_activity',
        'trigger_value' => '3',
        'action_type' => 'send_email',
        'template_name' => 'Template Comercial',
        'template_body' => 'Contato pendente para o deal {{deal_id}}',
        'active' => true,
        'order' => 1,
        'only_if_no_recent_activity' => true,
        'cooldown_hours' => 24,
    ]);

    $deal->forceFill(['updated_at' => now()->subDays(4)])->saveQuietly();

    app(DealSLAService::class)->evaluateDeal($deal->fresh());

    Notification::assertSentTo(
        $admin,
        DealFollowupAlertNotification::class,
        fn (DealFollowupAlertNotification $notification): bool =>
            str_contains((string) ($notification->toArray($admin)['title'] ?? ''), 'Template Comercial')
    );
});
