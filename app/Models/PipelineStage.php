<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PipelineStage extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'pipeline_id',
        'name',
        'position',
        'type',
        'probability',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'probability' => 'integer',
            'active' => 'boolean',
        ];
    }

    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'stage_id');
    }

    public function slas(): HasMany
    {
        return $this->hasMany(DealSLA::class, 'stage_id');
    }

    public function followupRules(): HasMany
    {
        return $this->hasMany(DealFollowupRule::class, 'stage_id');
    }
}
