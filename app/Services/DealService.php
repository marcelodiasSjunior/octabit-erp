<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Deal\CreateDealDTO;
use App\DTOs\Deal\UpdateDealDTO;
use App\Enums\DealStatus;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Contracts\DealRepositoryInterface;
use App\Services\DealFollowupService;
use Illuminate\Pagination\LengthAwarePaginator;

class DealService
{
    public function __construct(
        private readonly DealRepositoryInterface   $repository,
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly DealFollowupService       $followupService
    ) {}

    public function checkClientEligibility(int $clientId): void
    {
        $client = $this->clientRepository->findById($clientId);

        if (!$client || !in_array($client->status->value, ['lead', 'active'], true)) {
            abort(422, 'O cliente selecionado não é elegível para uma oportunidade.');
        }
    }

    public function list(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    public function findOrFail(int $id): Deal
    {
        return $this->repository->findOrFail($id);
    }

    public function create(CreateDealDTO $dto, ?int $userId = null): Deal
    {
        $status = $this->determineStatusFromStage($dto->stageId);

        $deal = $this->repository->create([
            ...$dto->toArray(),
            'status'    => $status,
            'closed_at' => $this->getClosedAt($status),
        ]);

        $this->followupService->initializeStageHistory($deal, $userId);

        return $deal;
    }

    public function update(int $id, UpdateDealDTO $dto): Deal
    {
        $status = $this->determineStatusFromStage($dto->stageId);

        return $this->repository->update($id, [
            ...$dto->toArray(),
            'status'    => $status,
            'closed_at' => $this->getClosedAt($status),
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function moveStage(int $id, int $stageId, ?int $userId = null): Deal
    {
        $deal  = $this->findOrFail($id);
        $stage = PipelineStage::findOrFail($stageId);

        $status = $this->determineStatusFromStage($stage->id);

        $this->followupService->recordStageTransition($deal, $stage, $userId);

        return $this->repository->update($id, [
            'stage_id'  => $stage->id,
            'status'    => $status,
            'closed_at' => $this->getClosedAt($status),
        ]);
    }

    /** Activity Management */

    public function addActivity(int $dealId, array $data, int $userId): \App\Models\DealActivity
    {
        $deal = $this->findOrFail($dealId);
        
        return $deal->activities()->create([
            ...$data,
            'user_id' => $userId,
        ]);
    }

    public function completeActivity(int $dealId, int $activityId): void
    {
        $deal = $this->findOrFail($dealId);
        
        $activity = $deal->activities()->findOrFail($activityId);
        $activity->update([
            'done'         => true,
            'completed_at' => now(),
        ]);
    }

    public function deleteActivity(int $dealId, int $activityId): void
    {
        $deal = $this->findOrFail($dealId);
        
        $activity = $deal->activities()->findOrFail($activityId);
        $activity->delete();
    }

    /** Dashboard metrics delegating to repository */
    public function countOpen(): int { return $this->repository->countOpen(); }
    public function countWonThisMonth(): int { return $this->repository->countWonThisMonth(); }
    public function weightedPipeline(): float { return $this->repository->weightedPipeline(); }

    /** Business Logic Helper */
    private function determineStatusFromStage(int $stageId): DealStatus
    {
        $stage = PipelineStage::findOrFail($stageId);

        return match ($stage->type) {
            'won'   => DealStatus::Won,
            'lost'  => DealStatus::Lost,
            default => DealStatus::Open,
        };
    }

    private function getClosedAt(DealStatus $status): ?\DateTimeInterface
    {
        return $status === DealStatus::Open ? null : now();
    }
}
