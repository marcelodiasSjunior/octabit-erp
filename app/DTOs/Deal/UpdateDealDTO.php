<?php

declare(strict_types=1);

namespace App\DTOs\Deal;

final readonly class UpdateDealDTO
{
    public function __construct(
        public int     $clientId,
        public int     $pipelineId,
        public int     $stageId,
        public string  $title,
        public float   $value,
        public ?string $expectedCloseDate = null,
        public ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            clientId:          (int) $data['client_id'],
            pipelineId:        (int) $data['pipeline_id'],
            stageId:           (int) $data['stage_id'],
            title:             $data['title'],
            value:             (float) $data['value'],
            expectedCloseDate: $data['expected_close_date'] ?? null,
            notes:             $data['notes'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'client_id'           => $this->clientId,
            'pipeline_id'         => $this->pipelineId,
            'stage_id'            => $this->stageId,
            'title'               => $this->title,
            'value'               => $this->value,
            'expected_close_date' => $this->expectedCloseDate,
            'notes'               => $this->notes,
        ];
    }
}
