<?php

declare(strict_types=1);

use App\Jobs\ProcessDealFollowupsJob;
use Illuminate\Support\Facades\Bus;

it('dispatches follow-up processing job from command', function () {
    Bus::fake();

    $this->artisan('deals:dispatch-followups-job')
        ->assertExitCode(0);

    Bus::assertDispatched(ProcessDealFollowupsJob::class);
});
