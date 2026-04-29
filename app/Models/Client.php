<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->company_name ?? $this->name;
    }

    public function getFormattedDocumentAttribute(): ?string
    {
        if (empty($this->document)) {
            return null;
        }

        $doc = preg_replace('/\D/', '', $this->document);

        if (strlen($doc) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc);
        }

        if (strlen($doc) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc);
        }

        return $this->document;
    }
}
