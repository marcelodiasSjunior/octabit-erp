<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTOs\Deal\CreateDealDTO;
use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Services\DealFollowupService;
use App\Services\DealService;
use Mockery;
use Symfony\Component\HttpKernel\Exception\HttpException;

beforeEach(function () {
    $this->repository = Mockery::mock(DealRepositoryInterface::class);
    $this->clientRepository = Mockery::mock(ClientRepositoryInterface::class);
    $this->followupService = Mockery::mock(DealFollowupService::class);
    
    $this->service = new DealService(
        $this->repository,
        $this->clientRepository,
        $this->followupService
    );
});

afterEach(function () {
    Mockery::close();
});

it('should allow eligible clients (lead or active) for deals', function () {
    $client = new \App\Models\Client(['status' => \App\Enums\ClientStatus::Lead]);
    
    $this->clientRepository->shouldReceive('findById')
        ->with(1)
        ->andReturn($client);

    $this->service->checkClientEligibility(1);
    
    expect(true)->toBeTrue(); // No exception thrown
});

it('should throw exception for ineligible clients', function () {
    $client = new \App\Models\Client(['status' => \App\Enums\ClientStatus::Inactive]);
    
    $this->clientRepository->shouldReceive('findById')
        ->with(1)
        ->andReturn($client);

    $this->service->checkClientEligibility(1);
})->throws(HttpException::class, 'O cliente selecionado não é elegível para uma oportunidade.');

it('should add an activity to a deal', function () {
    $deal = Mockery::mock(\App\Models\Deal::class);
    $activitiesRelation = Mockery::mock();
    
    $this->repository->shouldReceive('findOrFail')
        ->with(123)
        ->andReturn($deal);

    $deal->shouldReceive('activities')
        ->andReturn($activitiesRelation);

    $activitiesRelation->shouldReceive('create')
        ->with([
            'title' => 'Test Activity',
            'user_id' => 1
        ])
        ->andReturn(new \App\Models\DealActivity());

    $this->service->addActivity(123, ['title' => 'Test Activity'], 1);
});

it('should complete an activity', function () {
    $deal = Mockery::mock(\App\Models\Deal::class);
    $activitiesRelation = Mockery::mock();
    $activity = Mockery::mock(\App\Models\DealActivity::class);

    $this->repository->shouldReceive('findOrFail')
        ->with(123)
        ->andReturn($deal);

    $deal->shouldReceive('activities')
        ->andReturn($activitiesRelation);

    $activitiesRelation->shouldReceive('findOrFail')
        ->with(456)
        ->andReturn($activity);

    $activity->shouldReceive('update')
        ->once()
        ->with(Mockery::on(function ($arg) {
            return $arg['done'] === true && isset($arg['completed_at']);
        }));

    $this->service->completeActivity(123, 456);
});
