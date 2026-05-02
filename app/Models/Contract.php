<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ContractStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'company_id',
        'sequential_number',
        'client_id',
        'file_path',
        'start_date',
        'end_date',
        'value',
        'status',
        'notes',
    ];

    public function getFormattedNumberAttribute(): string
    {
        return 'CTR-' . str_pad((string) $this->sequential_number, 5, '0', STR_PAD_LEFT);
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'value'      => 'decimal:2',
            'status'     => ContractStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function isExpired(): bool
    {
        return $this->end_date !== null && $this->end_date->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('status', ContractStatus::Active->value);
    }
}
