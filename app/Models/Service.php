<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'base_price',
        'setup_price',
        'description',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'type'        => ServiceType::class,
            'base_price'  => 'decimal:2',
            'setup_price' => 'decimal:2',
            'active'      => 'boolean',
        ];
    }

    public function clientServices(): HasMany
    {
        return $this->hasMany(ClientService::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
