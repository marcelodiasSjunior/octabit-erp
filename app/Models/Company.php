<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Traits\HasMasks;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Company extends Model
{
    use HasFactory, HasMasks;

    protected $fillable = [
        'name',
        'cnpj',
        'subdomain',
        'status',
        'plan',
        'settings',
        'uuid',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    protected function cnpj(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? $this->formatDocument($value) : null,
            set: fn (?string $value) => $value ? $this->formatDocument($value) : null,
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->uuid)) {
                $company->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class)->where('role', \App\Enums\UserRole::AdminEmpresa);
    }
}
