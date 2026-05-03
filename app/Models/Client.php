<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ClientStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\HasMasks;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant, HasMasks;

    protected $fillable = [
        'name',
        'company_name',
        'document',
        'email',
        'phone',
        'status',
        'notes',
        'zip_code',
        'address',
        'city',
        'state',
    ];

    protected function casts(): array
    {
        return [
            'status' => ClientStatus::class,
        ];
    }

    protected function document(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? $this->formatDocument($value) : null,
            set: fn (?string $value) => $value ? $this->formatDocument($value) : null,
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? $this->formatPhone($value) : null,
            set: fn (?string $value) => $value ? $this->formatPhone($value) : null,
        );
    }

    // ── Relationships ──────────────────────────────────────────────

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function clientServices(): HasMany
    {
        return $this->hasMany(ClientService::class);
    }

    public function accountsReceivable(): HasMany
    {
        return $this->hasMany(AccountsReceivable::class);
    }

    public function clientProducts(): HasMany
    {
        return $this->hasMany(ClientProduct::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(ClientInteraction::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', ClientStatus::Active->value);
    }

    public function scopeLeads($query)
    {
        return $query->where('status', ClientStatus::Lead->value);
    }

    // ── Accessors ─────────────────────────────────────────────────

    public function getDisplayNameAttribute(): string
    {
        return empty($this->company_name) ? $this->name : $this->company_name;
    }
}
