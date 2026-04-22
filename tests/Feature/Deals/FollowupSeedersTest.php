<?php

declare(strict_types=1);

use App\Models\DealFollowupRule;
use App\Models\DealSLA;
use Database\Seeders\FollowupRuleSeeder;
use Database\Seeders\FollowupSLASeeder;

it('seeds default sla and follow-up rules idempotently', function () {
    $this->seed(FollowupSLASeeder::class);
    $this->seed(FollowupRuleSeeder::class);

    $slaCount = DealSLA::count();
    $ruleCount = DealFollowupRule::count();

    $this->seed(FollowupSLASeeder::class);
    $this->seed(FollowupRuleSeeder::class);

    expect(DealSLA::count())->toBe($slaCount)
        ->and(DealFollowupRule::count())->toBe($ruleCount)
        ->and($slaCount)->toBeGreaterThan(0)
        ->and($ruleCount)->toBeGreaterThan(0);
});
