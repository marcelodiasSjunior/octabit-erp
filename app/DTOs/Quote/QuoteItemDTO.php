<?php

declare(strict_types=1);

namespace App\DTOs\Quote;

final readonly class QuoteItemDTO
{
    public function __construct(
        public string  $description,
        public float   $quantity,
        public float   $unitPrice,
        public float   $discount = 0,
        public ?int    $productId = null,
        public ?int    $serviceId = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            description: $data['description'],
            quantity:    (float) $data['quantity'],
            unitPrice:   (float) $data['unit_price'],
            discount:    (float) ($data['discount'] ?? 0),
            productId:   isset($data['product_id']) ? (int) $data['product_id'] : null,
            serviceId:   isset($data['service_id']) ? (int) $data['service_id'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'unit_price'  => $this->unitPrice,
            'discount'    => $this->discount,
            'product_id'  => $this->productId,
            'service_id'  => $this->serviceId,
        ];
    }
}
