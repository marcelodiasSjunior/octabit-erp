<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Enums\DealActivityType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealActivity extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'deal_id',
        'user_id',
        'type',
        'title',
        'notes',
        'scheduled_at',
        'done',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'type'         => DealActivityType::class,
            'scheduled_at' => 'datetime',
            'completed_at' => 'datetime',
            'done'         => 'boolean',
        ];
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('done', false)
            ->where('scheduled_at', '<', now());
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('done', false)
            ->where('scheduled_at', '>=', now());
    }
}
