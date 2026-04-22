<?php

use App\Jobs\ProcessDealFollowupsJob;
use App\Services\DealSLAService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('deals:process-followups', function (DealSLAService $service) {
    $processed = $service->processOpenDeals();
    $escalated = $service->processEscalations();

    $this->info("Follow-ups processados: {$processed}; Escalados: {$escalated}");
})->purpose('Processa SLAs e regras de follow-up para oportunidades em aberto')->everyTenMinutes();

Artisan::command('deals:dispatch-followups-job', function () {
    ProcessDealFollowupsJob::dispatch();

    $this->info('Job de follow-ups despachado.');
})->purpose('Despacha job de processamento de follow-ups')->everyTenMinutes();
