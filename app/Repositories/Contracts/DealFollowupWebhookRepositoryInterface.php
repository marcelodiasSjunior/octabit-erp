<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface DealFollowupWebhookRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveByEvent(string $event): \Illuminate\Database\Eloquent\Collection;
}
