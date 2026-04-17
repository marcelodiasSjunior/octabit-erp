<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountsReceivable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts_receivable';

    protected $fillable = [
        'client_id',
        'description',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'reference_type',
        'reference_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'due_date'     => 'date',
            'payment_date' => 'date',
            'status'       => PaymentStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::Pending->value);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', PaymentStatus::Overdue->value);
    }

    public function scopePaid($query)
    {
        return $query->where('status', PaymentStatus::Paid->value);
    }

    public function scopeDueThisMonth($query)
    {
        return $query->whereMonth('due_date', now()->month)
                     ->whereYear('due_date', now()->year);
    }

    /**
     * Recalculate status based on dates. Call before saving.
     */
    public function recalculateStatus(): void
    {
        $this->status = PaymentStatus::calculate(
            $this->due_date,
            $this->payment_date
        );
    }
}
