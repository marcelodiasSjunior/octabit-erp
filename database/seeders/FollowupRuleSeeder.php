<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DealFollowupRule;
use App\Models\DealSLA;
use Illuminate\Database\Seeder;

class FollowupRuleSeeder extends Seeder
{
    public function run(): void
    {
        DealSLA::query()->each(function (DealSLA $sla): void {
            DealFollowupRule::firstOrCreate(
                [
                    'pipeline_id' => $sla->pipeline_id,
                    'stage_id' => $sla->stage_id,
                    'name' => 'D-3 sem atividade',
                ],
                [
                    'deal_sla_id' => $sla->id,
                    'trigger_type' => 'days_without_activity',
                    'trigger_value' => '3',
                    'action_type' => 'create_activity',
                    'activity_type' => 'task',
                    'active' => true,
                    'order' => 1,
                    'only_if_no_recent_activity' => true,
                    'cooldown_hours' => 24,
                ]
            );
        });
    }
}
