<?php

declare(strict_types=1);

namespace App\DTOs\Client;

use App\Enums\ClientStatus;

final readonly class CreateClientDTO
{
    public function __construct(
        public string       $name,
        public string       $email,
        public ?string      $document,
        public ClientStatus $status,
        public ?string      $companyName = null,
        public ?string      $phone       = null,
        public ?string      $notes       = null,
        public ?string      $zipCode     = null,
        public ?string      $address     = null,
        public ?string      $city        = null,
        public ?string      $state       = null,
        public array        $tags        = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:        $data['name'],
            email:       $data['email'],
            document:    $data['document'],
            status:      ClientStatus::from($data['status'] ?? ClientStatus::Lead->value),
            companyName: $data['company_name'] ?? null,
            phone:       $data['phone'] ?? null,
            notes:       $data['notes'] ?? null,
            zipCode:     $data['zip_code'] ?? null,
            address:     $data['address'] ?? null,
            city:        $data['city'] ?? null,
            state:       $data['state'] ?? null,
            tags:        $data['tags'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'name'         => $this->name,
            'email'        => $this->email,
            'document'     => $this->document,
            'status'       => $this->status->value,
            'company_name' => $this->companyName,
            'phone'        => $this->phone,
            'notes'        => $this->notes,
            'zip_code'     => $this->zipCode,
            'address'      => $this->address,
            'city'         => $this->city,
            'state'        => $this->state,
            'tags'         => $this->tags,
        ];
    }
}
