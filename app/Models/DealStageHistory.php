<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DealStageHistory extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'deal_stage_history';

    protected $fillable = [
        'deal_id',
        'from_stage_id',
        'to_stage_id',
        'entered_at',
        'exited_at',
        'days_in_stage',
        'user_id',
        'trigger_type',
        'reason',
        'notes',
        'deal_value_at_stage',
        'probability_at_stage',
        'was_won_or_lost',
    ];

    protected function casts(): array
    {
        return [
            'entered_at' => 'datetime',
            'exited_at' => 'datetime',
            'days_in_stage' => 'integer',
            'deal_value_at_stage' => 'decimal:2',
            'probability_at_stage' => 'decimal:2',
            'was_won_or_lost' => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function fromStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'from_stage_id');
    }

    public function toStage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'to_stage_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────────

    public function scopeInCurrentStage(Builder $query, int $stageId): Builder
    {
        return $query->where('to_stage_id', $stageId)
            ->whereNull('exited_at');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereNotNull('exited_at');
    }

    public function scopeByTrigger(Builder $query, string $trigger): Builder
    {
        return $query->where('trigger_type', $trigger);
    }

    public function scopeWonOrLost(Builder $query): Builder
    {
        return $query->where('was_won_or_lost', true);
    }

    public function scopeTimeInRange(Builder $query, int $minDays, int $maxDays): Builder
    {
        return $query->whereBetween('days_in_stage', [$minDays, $maxDays]);
    }

    // ── Methods ────────────────────────────────────────

    /**
     * Marca saída do estágio
     */
    public function markExit(): void
    {
        $daysInStage = (int) $this->entered_at->diffInDays($this->exited_at ?? now());
        
        $this->update([
            'exited_at' => now(),
            'days_in_stage' => $daysInStage,
        ]);
    }

    /**
     * Calcula tempo no estágio (se ainda está ativo)
     */
    public function getDaysInCurrentStage(): int
    {
        if ($this->exited_at) {
            return $this->days_in_stage;
        }

        return (int) $this->entered_at->diffInDays(now());
    }

    /**
     * Verifica se saiu por vitória/derrota
     */
    public function isTerminalStage(): bool
    {
        return $this->was_won_or_lost || $this->toStage?->type !== 'open';
    }

    /**
     * Duração legível
     */
    public function getReadableDuration(): string
    {
        $days = $this->getDaysInCurrentStage();
        
        if ($days === 0) {
            return 'Menos de 1 dia';
        }

        if ($days === 1) {
            return '1 dia';
        }

        if ($days < 7) {
            return "$days dias";
        }

        $weeks = intval($days / 7);
        $remaining = $days % 7;

        if ($remaining === 0) {
            return $weeks === 1 ? '1 semana' : "$weeks semanas";
        }

        return $weeks === 1 ? "1 semana e $remaining dias" : "$weeks semanas e $remaining dias";
    }

    /**
     * Calcula valor ganho/perdido nesta etapa
     */
    public function getValueChangeFromInitial(): float
    {
        if (!$this->deal_value_at_stage || !$this->deal->value) {
            return 0;
        }

        return (float) ($this->deal->value - $this->deal_value_at_stage);
    }
}
