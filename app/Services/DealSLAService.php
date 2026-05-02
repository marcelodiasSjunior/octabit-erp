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

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Repositories\Contracts\DealActivityRepositoryInterface;
use App\Repositories\Contracts\DealFollowupRuleRepositoryInterface;
use App\Repositories\Contracts\DealFollowupWebhookRepositoryInterface;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Repositories\Contracts\DealSLARepositoryInterface;
use App\Repositories\Contracts\DealSLAViolationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DealSLAService
{
    public function __construct(
        private readonly DealRepositoryInterface            $dealRepository,
        private readonly DealSLARepositoryInterface          $slaRepository,
        private readonly DealSLAViolationRepositoryInterface $violationRepository,
        private readonly DealFollowupRuleRepositoryInterface $ruleRepository,
        private readonly DealFollowupWebhookRepositoryInterface $webhookRepository,
        private readonly DealActivityRepositoryInterface     $activityRepository,
        private readonly UserRepositoryInterface             $userRepository
    ) {}

    public function getViolationsPaginated(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->violationRepository->paginateFiltered($filters, $perPage);
    }

    public function getDashboardStats(): array
    {
        return $this->violationRepository->getDashboardStats();
    }

    /** Settings Management */

    public function getAllSlas(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->slaRepository->allWithRelations();
    }

    public function getAllRules(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->ruleRepository->allWithRelations();
    }

    public function createSla(array $data): DealSLA
    {
        return DB::transaction(function() use ($data) {
            $data['active'] = (bool) ($data['active'] ?? false);
            return $this->slaRepository->create($data);
        });
    }

    public function createRule(array $data): DealFollowupRule
    {
        return DB::transaction(function() use ($data) {
            $data['active'] = (bool) ($data['active'] ?? false);
            $data['only_if_no_recent_activity'] = (bool) ($data['only_if_no_recent_activity'] ?? false);
            return $this->ruleRepository->create($data);
        });
    }

    public function processOpenDeals(): int
    {
        $processed = 0;

        $this->dealRepository->chunkOpenDeals(100, function ($deals) use (&$processed): void {
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

        $sla = $deal->applicableSLAs()->first();

        if ($sla && $sla->isViolated($deal)) {
            $this->createViolationIfNeeded($deal, $sla);
        }

        $rules = $this->ruleRepository->getActiveForDeal($deal);

        foreach ($rules as $rule) {
            if ($this->ruleMatches($deal, $rule)) {
                $this->executeRuleAction($deal, $rule);
            }
        }
    }

    private function createViolationIfNeeded(Deal $deal, DealSLA $sla): void
    {
        DB::transaction(function() use ($deal, $sla) {
            $alreadyExists = $this->violationRepository->existsUnresolved($deal->id, $sla->id);

            if ($alreadyExists) {
                return;
            }

            $violation = $this->violationRepository->create([
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
        });
    }

    public function processEscalations(): int
    {
        $manager = $this->userRepository->findFirstByRole(UserRole::Manager->value);

        if (!$manager) {
            return 0;
        }

        $escalated = 0;

        $this->violationRepository->chunkUnresolvedEscalatable(100, function ($violations) use (&$escalated, $manager): void {
            DB::transaction(function() use ($violations, &$escalated, $manager) {
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
            $admins = $this->userRepository->getAllByRole(UserRole::Admin->value);

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
            $inCooldown = $this->activityRepository->existsRecentForDeal($deal->id, $title, (int)$rule->cooldown_hours);

            if ($inCooldown) {
                return;
            }
        }

        $this->activityRepository->create([
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
        $admins = $this->userRepository->getAllByRole(UserRole::Admin->value);

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new DealFollowupAlertNotification($title, $body));
        }
    }

    private function sendWebhook(string $event, array $payload): void
    {
        $webhooks = $this->webhookRepository->getActiveByEvent($event);

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
