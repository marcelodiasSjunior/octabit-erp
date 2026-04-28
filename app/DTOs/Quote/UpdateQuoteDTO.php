<?php

declare(strict_types=1);

namespace App\DTOs\Quote;

final readonly class UpdateQuoteDTO
{
    /**
     * @param QuoteItemDTO[] $items
     */
    public function __construct(
        public int    $clientId,
        public string $validUntil,
        public array  $items,
    ) {}

    public static function fromArray(array $data): self
    {
        $items = array_map(
            fn (array $item) => QuoteItemDTO::fromArray($item),
            $data['items']
        );

        return new self(
            clientId:   (int) $data['client_id'],
            validUntil: $data['valid_until'],
            items:      $items,
        );
    }

    public function toArray(): array
    {
        return [
            'client_id'   => $this->clientId,
            'valid_until' => $this->validUntil,
            'items'       => array_map(fn (QuoteItemDTO $item) => $item->toArray(), $this->items),
        ];
    }
}
