<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DealStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'pipeline_id',
        'stage_id',
        'title',
        'value',
        'status',
        'expected_close_date',
        'closed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'status' => DealStatus::class,
            'expected_close_date' => 'date',
            'closed_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'stage_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(DealActivity::class)->orderBy('scheduled_at');
    }

    public function stageHistory(): HasMany
    {
        return $this->hasMany(DealStageHistory::class)->orderBy('entered_at', 'desc');
    }

    public function slaViolations(): HasMany
    {
        return $this->hasMany(DealSLAViolation::class)->orderBy('due_at', 'desc');
    }

    public function applicableSLAs()
    {
        return DealSLA::forPipeline($this->pipeline_id)
            ->forStage($this->stage_id)
            ->active()
            ->ordered();
    }

}
