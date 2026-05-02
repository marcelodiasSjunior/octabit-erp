<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, BelongsToTenant;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
        'dashboard_layout',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
            'dashboard_layout'  => 'array',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin || $this->role === UserRole::AdminEmpresa;
    }

    public function isMasterGlobal(): bool
    {
        return $this->role === UserRole::MasterGlobal;
    }

    public function isAdminEmpresa(): bool
    {
        return $this->role === UserRole::AdminEmpresa;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::User;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
