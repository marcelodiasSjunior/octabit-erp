<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Enums\InteractionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientInteraction extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'client_id',
        'user_id',
        'type',
        'description',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'type'        => InteractionType::class,
            'occurred_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
