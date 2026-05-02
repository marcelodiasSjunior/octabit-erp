<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'status',
        'plan',
        'settings',
        'uuid',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class)->where('role', \App\Enums\UserRole::AdminEmpresa);
    }
}
