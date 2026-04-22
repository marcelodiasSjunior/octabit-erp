<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DealStatus;
use App\Enums\UserRole;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\DealFollowupRule;
use App\Models\DealFollowupWebhook;
use App\Models\DealSLA;
use App\Models\DealSLAViolation;
use App\Models\User;
use App\Notifications\DealFollowupAlertNotification;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class DealSLAService
{
    public function processOpenDeals(): int
    {
        $processed = 0;

        Deal::query()
            ->where('status', DealStatus::Open->value)
            ->chunkById(100, function ($deals) use (&$processed): void {
                foreach ($deals as $deal) {
                    $this->evaluateDeal($deal);
                    $processed++;
                }
            });

        return $processed;
    }

    public function evaluateDeal(Deal $deal): void
    {
        if ($deal->status !== DealStatus::Open) {
            return;
        }

        $deal->loadMissing('activities');

        $sla = $deal->applicableSLAs()->first();

        if ($sla && $sla->isViolated($deal)) {
            $this->createViolationIfNeeded($deal, $sla);
        }

        $rules = DealFollowupRule::query()
            ->active()
            ->forPipeline($deal->pipeline_id)
            ->forStage($deal->stage_id)
            ->ordered()
            ->get();

        foreach ($rules as $rule) {
            if ($this->ruleMatches($deal, $rule)) {
                $this->executeRuleAction($deal, $rule);
            }
        }
    }

    private function createViolationIfNeeded(Deal $deal, DealSLA $sla): void
    {
        $alreadyExists = DealSLAViolation::query()
            ->where('deal_id', $deal->id)
            ->where('sla_rule_id', $sla->id)
            ->where('violation_type', 'response_timeout')
            ->where('resolved', false)
            ->exists();

        if ($alreadyExists) {
            return;
        }

        $violation = DealSLAViolation::create([
            'deal_id' => $deal->id,
            'sla_rule_id' => $sla->id,
            'violation_type' => 'response_timeout',
            'due_at' => now()->subHours(max(1, (int) $sla->response_sla_hours)),
            'severity' => 'warning',
            'acknowledged' => false,
            'resolved' => false,
            'days_late' => 0,
        ]);

        $this->notifyAdmins(
            'Violação de SLA detectada',
            sprintf('Deal #%d violou SLA %s.', $deal->id, $sla->name)
        );

        $this->sendWebhook('violation.created', [
            'violation_id' => $violation->id,
            'deal_id' => $deal->id,
            'severity' => $violation->severity,
        ]);
    }

    public function processEscalations(): int
    {
        $manager = User::query()->where('role', UserRole::Manager->value)->orderBy('id')->first();

        if (!$manager) {
            return 0;
        }

        $escalated = 0;

        DealSLAViolation::query()
            ->where('resolved', false)
            ->whereNull('escalated_to')
            ->where('due_at', '<=', now()->subDay())
            ->chunkById(100, function ($violations) use (&$escalated, $manager): void {
                foreach ($violations as $violation) {
                    $violation->escalateTo($manager, 'Escalação automática por atraso.');
                    $escalated++;

                    Notification::send($manager, new DealFollowupAlertNotification(
                        'Violação escalada',
                        sprintf('Violação #%d escalada para você.', $violation->id)
                    ));

                    $this->sendWebhook('violation.escalated', [
                        'violation_id' => $violation->id,
                        'escalated_to' => $manager->id,
                        'severity' => $violation->fresh()->severity,
                    ]);
                }
            });

        return $escalated;
    }

    private function ruleMatches(Deal $deal, DealFollowupRule $rule): bool
    {
        if (!$rule->shouldExecuteFor($deal)) {
            return false;
        }

        if ($rule->trigger_type !== 'days_without_activity') {
            return false;
        }

        $thresholdDays = (int) $rule->trigger_value;
        $lastActivityAt = $deal->activities()->max('scheduled_at');

        $referenceDate = $lastActivityAt instanceof CarbonInterface
            ? $lastActivityAt
            : ($lastActivityAt ? now()->parse((string) $lastActivityAt) : $deal->updated_at);

        return $referenceDate ? $referenceDate->diffInDays(now()) >= $thresholdDays : false;
    }

    private function executeRuleAction(Deal $deal, DealFollowupRule $rule): void
    {
        if ($rule->action_type === 'send_email') {
            $admins = User::query()->where('role', UserRole::Admin->value)->get();

            if ($admins->isNotEmpty()) {
                $body = str_replace('{{deal_id}}', (string) $deal->id, (string) $rule->template_body);

                Notification::send($admins, new DealFollowupAlertNotification(
                    'Template ' . ($rule->template_name ?: $rule->name),
                    $body !== '' ? $body : 'Regra de email disparada para follow-up.',
                ));
            }

            return;
        }

        if ($rule->action_type !== 'create_activity') {
            return;
        }

        $title = sprintf('Follow-up automático: %s', $rule->name);

        if ($rule->cooldown_hours > 0) {
            $inCooldown = DealActivity::query()
                ->where('deal_id', $deal->id)
                ->where('title', $title)
                ->where('created_at', '>=', now()->subHours($rule->cooldown_hours))
                ->exists();

            if ($inCooldown) {
                return;
            }
        }

        DealActivity::create([
            'deal_id' => $deal->id,
            'user_id' => null,
            'type' => $rule->activity_type ?: 'task',
            'title' => $title,
            'notes' => $rule->template_body,
            'scheduled_at' => now()->addDay(),
            'done' => false,
        ]);
    }

    private function notifyAdmins(string $title, string $body): void
    {
        $admins = User::query()->where('role', UserRole::Admin->value)->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new DealFollowupAlertNotification($title, $body));
        }
    }

    private function sendWebhook(string $event, array $payload): void
    {
        $webhooks = DealFollowupWebhook::query()->active()->where('event', $event)->get();

        foreach ($webhooks as $webhook) {
            Http::withHeaders([
                'X-Followup-Event' => $event,
                'X-Followup-Signature' => (string) $webhook->secret,
            ])->post($webhook->url, [
                'event' => $event,
                'payload' => $payload,
                'sent_at' => now()->toISOString(),
            ]);
        }
    }
}
