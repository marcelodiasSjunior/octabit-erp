<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountsPayable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts_payable';

    protected $fillable = [
        'description',
        'amount',
        'due_date',
        'payment_date',
        'status',
        'category',
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

    public function scopePending($query)
    {
        return $query->where('status', PaymentStatus::Pending->value);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', PaymentStatus::Overdue->value);
    }

    public function recalculateStatus(): void
    {
        $this->status = PaymentStatus::calculate(
            $this->due_date,
            $this->payment_date
        );
    }
}
