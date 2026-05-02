<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProduct extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'client_id',
        'product_id',
        'quantity',
        'unit_price',
        'purchased_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'unit_price'   => 'decimal:2',
            'purchased_at' => 'date',
            'quantity'     => 'integer',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectivePriceAttribute(): string
    {
        return $this->unit_price ?? $this->product->price;
    }

    public function getTotalAttribute(): float
    {
        return (float) ($this->unit_price ?? $this->product->price) * $this->quantity;
    }
}
