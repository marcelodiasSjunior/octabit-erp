<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DealSLA extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deal_slas';

    protected $fillable = [
        'pipeline_id',
        'stage_id',
        'name',
        'description',
        'response_sla_hours',
        'followup_interval_days',
        'escalation_threshold_days',
        'active',
        'priority',
        'max_followups',
        'warning_hours_before',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'response_sla_hours' => 'integer',
            'followup_interval_days' => 'integer',
            'escalation_threshold_days' => 'integer',
            'priority' => 'integer',
            'max_followups' => 'integer',
            'warning_hours_before' => 'integer',
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

    public function violations(): HasMany
    {
        return $this->hasMany(DealSLAViolation::class, 'sla_rule_id');
    }

    public function rules(): HasMany
    {
        return $this->hasMany(DealFollowupRule::class, 'deal_sla_id');
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
        return $query->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc');
    }

    // ── Methods ────────────────────────────────────────

    public function isViolated(Deal $deal): bool
    {
        if ($deal->activities->isEmpty()) {
            return true;
        }

        $lastActivity = $deal->activities()->latest('scheduled_at')->first();
        
        if (!$lastActivity) {
            return true;
        }

        if ($lastActivity->done) {
            return false;
        }

        $deadline = $lastActivity->scheduled_at->addHours($this->response_sla_hours);
        
        return now()->isAfter($deadline);
    }

    public function getDaysUntilViolation(Deal $deal): ?int
    {
        $lastActivity = $deal->activities()->latest('scheduled_at')->first();
        
        if (!$lastActivity) {
            return 0;
        }

        $deadline = $lastActivity->scheduled_at->addHours($this->response_sla_hours);
        $daysLeft = now()->diffInDays($deadline, false);
        
        return max(0, (int) $daysLeft);
    }

    public function getReadableDescription(): string
    {
        $parts = [];

        if ($this->response_sla_hours) {
            $parts[] = "Responder em {$this->response_sla_hours}h";
        }

        if ($this->followup_interval_days) {
            $parts[] = "Follow-up a cada {$this->followup_interval_days} dias";
        }

        if ($this->escalation_threshold_days) {
            $parts[] = "Escalar em {$this->escalation_threshold_days} dias";
        }

        return implode(' | ', $parts);
    }
}
