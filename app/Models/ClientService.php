<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ClientServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientService extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'custom_price',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'custom_price' => 'decimal:2',
            'start_date'   => 'date',
            'end_date'     => 'date',
            'status'       => ClientServiceStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * The effective price for this client: custom price or the service base price.
     */
    public function getEffectivePriceAttribute(): string
    {
        return $this->custom_price ?? $this->service->base_price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', ClientServiceStatus::Active->value);
    }
}
