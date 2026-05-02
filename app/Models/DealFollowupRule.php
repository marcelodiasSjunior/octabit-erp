<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DealFollowupRule extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'pipeline_id',
        'stage_id',
        'deal_sla_id',
        'trigger_type',
        'trigger_value',
        'action_type',
        'activity_type',
        'template_name',
        'template_body',
        'notification_channel',
        'name',
        'description',
        'active',
        'order',
        'only_if_no_recent_activity',
        'cooldown_hours',
        'max_executions',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'only_if_no_recent_activity' => 'boolean',
            'cooldown_hours' => 'integer',
            'max_executions' => 'integer',
            'order' => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────

    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'stage_id');
    }

    public function sla(): BelongsTo
    {
        return $this->belongsTo(DealSLA::class, 'deal_sla_id');
    }

    // ── Scopes ─────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeForPipeline(Builder $query, int $pipelineId): Builder
    {
        return $query->where('pipeline_id', $pipelineId);
    }

    public function scopeForStage(Builder $query, int $stageId): Builder
    {
        return $query->where(function ($q) use ($stageId) {
            $q->where('stage_id', $stageId)
              ->orWhereNull('stage_id');
        });
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc');
    }

    // ── Methods ────────────────────────────────────────

    /**
     * Verifica se a regra deve ser executada para este deal
     */
    public function shouldExecuteFor(Deal $deal): bool
    {
        // Se cooldown_hours configurado, verifica quando foi última execução
        if ($this->cooldown_hours > 0) {
            $lastViolation = $deal->slaViolations()
                ->where('created_at', '>=', now()->subHours($this->cooldown_hours))
                ->exists();

            if ($lastViolation) {
                return false;
            }
        }

        // Verifica condição de "sem atividade recente"
        if ($this->only_if_no_recent_activity) {
            $recentActivity = $deal->activities()
                ->where('created_at', '>=', now()->subHours(24))
                ->exists();

            if ($recentActivity) {
                return false;
            }
        }

        return true;
    }

    /**
     * Descrição legível da regra
     */
    public function getReadableDescription(): string
    {
        $trigger = match($this->trigger_type) {
            'stage_entered' => 'Quando entra em estágio',
            'days_without_activity' => "Sem atividade por {$this->trigger_value} dias",
            'expected_close_approaching' => "Faltam {$this->trigger_value} dias para close",
            'time_in_stage_exceeded' => "Passou {$this->trigger_value} dias em estágio",
            'deal_value_threshold' => "Valor acima de R$ {$this->trigger_value}",
            default => $this->trigger_type,
        };

        $action = match($this->action_type) {
            'create_activity' => "Criar {$this->activity_type}",
            'send_notification' => "Notificar {$this->notification_channel}",
            'send_email' => "Enviar email ({$this->template_name})",
            'escalate' => "Escalar para manager",
            'update_deal' => "Atualizar deal",
            default => $this->action_type,
        };

        return "$trigger → $action";
    }
}
