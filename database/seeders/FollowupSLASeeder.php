<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DealSLA;
use App\Models\Pipeline;
use Illuminate\Database\Seeder;

class FollowupSLASeeder extends Seeder
{
    public function run(): void
    {
        if (Pipeline::query()->count() === 0) {
            $this->call(PipelineSeeder::class);
        }

        Pipeline::query()->with('stages')->each(function (Pipeline $pipeline): void {
            $stage = $pipeline->stages->firstWhere('type', 'open') ?? $pipeline->stages->first();

            if (!$stage) {
                return;
            }

            DealSLA::firstOrCreate(
                [
                    'pipeline_id' => $pipeline->id,
                    'stage_id' => $stage->id,
                    'name' => 'SLA Padrão ' . $pipeline->name,
                ],
                [
                    'response_sla_hours' => 24,
                    'followup_interval_days' => 3,
                    'escalation_threshold_days' => 2,
                    'active' => true,
                    'priority' => 10,
                    'warning_hours_before' => 4,
                ]
            );
        });
    }
}
