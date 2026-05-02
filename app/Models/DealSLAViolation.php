<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DealSLAViolation extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $table = 'deal_sla_violations';

    protected $fillable = [
        'deal_id',
        'sla_rule_id',
        'violation_type',
        'due_at',
        'completed_at',
        'days_late',
        'severity',
        'acknowledged',
        'resolved',
        'assigned_to',
        'escalated_to',
        'escalated_at',
        'notes',
        'resolution_notes',
    ];

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'completed_at' => 'datetime',
            'escalated_at' => 'datetime',
            'acknowledged' => 'boolean',
            'resolved' => 'boolean',
            'days_late' => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function slaRule(): BelongsTo
    {
        return $this->belongsTo(DealSLA::class, 'sla_rule_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function escalatedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'escalated_to');
    }

    // ── Scopes ─────────────────────────────────────────

    public function scopeUnresolved(Builder $query): Builder
    {
        return $query->where('resolved', false);
    }

    public function scopeAcknowledged(Builder $query): Builder
    {
        return $query->where('acknowledged', true);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('resolved', false)
            ->where('acknowledged', false);
    }

    public function scopeBySeverity(Builder $query, string $severity): Builder
    {
        return $query->where('severity', $severity);
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_at', '<', now())
            ->where('resolved', false);
    }

    public function scopeEscalated(Builder $query): Builder
    {
        return $query->whereNotNull('escalated_to');
    }

    // ── Methods ────────────────────────────────────────

    /**
     * Marca como reconhecida
     */
    public function acknowledge(User $user): void
    {
        $this->update([
            'acknowledged' => true,
            'assigned_to' => $user->id,
        ]);
    }

    /**
     * Escalona para manager
     */
    public function escalateTo(User $user, ?string $reason = null): void
    {
        $this->update([
            'escalated_to' => $user->id,
            'escalated_at' => now(),
            'severity' => match($this->severity) {
                'warning' => 'critical',
                'critical' => 'severe',
                default => $this->severity,
            },
            'notes' => $reason ? $this->notes . "\n[ESCALAÇÃO] $reason" : $this->notes,
        ]);
    }

    /**
     * Marca como resolvida
     */
    public function resolve(?string $notes = null): void
    {
        $this->update([
            'resolved' => true,
            'completed_at' => now(),
            'resolution_notes' => $notes,
            'days_late' => max(0, (int) now()->diffInDays($this->due_at, false)),
        ]);
    }

    /**
     * Calcula dias de atraso
     */
    public function getCalculatedDaysLate(): int
    {
        $target = $this->completed_at ?? now();
        return max(0, (int) $target->diffInDays($this->due_at, false));
    }

    /**
     * Badge CSS para exibição
     */
    public function getSeverityBadgeClass(): string
    {
        return match($this->severity) {
            'warning' => 'bg-yellow-100 text-yellow-800',
            'critical' => 'bg-red-100 text-red-800',
            'severe' => 'bg-red-900 text-white',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
