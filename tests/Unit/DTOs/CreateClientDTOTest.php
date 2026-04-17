<?php

declare(strict_types=1);

use App\DTOs\Client\CreateClientDTO;
use App\Enums\ClientStatus;

it('creates DTO from array with required fields', function () {
    $dto = CreateClientDTO::fromArray([
        'name'     => 'João',
        'email'    => 'joao@test.com',
        'document' => '11122233344',
        'status'   => 'lead',
    ]);

    expect($dto->name)->toBe('João');
    expect($dto->email)->toBe('joao@test.com');
    expect($dto->document)->toBe('11122233344');
    expect($dto->status)->toBe(ClientStatus::Lead);
    expect($dto->companyName)->toBeNull();
    expect($dto->phone)->toBeNull();
    expect($dto->notes)->toBeNull();
});

it('creates DTO from array with all optional fields', function () {
    $dto = CreateClientDTO::fromArray([
        'name'         => 'Maria',
        'email'        => 'maria@test.com',
        'document'     => '22233344455',
        'status'       => 'active',
        'company_name' => 'Maria ME',
        'phone'        => '11999990000',
        'notes'        => 'VIP',
    ]);

    expect($dto->companyName)->toBe('Maria ME');
    expect($dto->phone)->toBe('11999990000');
    expect($dto->notes)->toBe('VIP');
    expect($dto->status)->toBe(ClientStatus::Active);
});

it('defaults status to lead when not provided', function () {
    $dto = CreateClientDTO::fromArray([
        'name'     => 'Pedro',
        'email'    => 'pedro@test.com',
        'document' => '33344455566',
    ]);

    expect($dto->status)->toBe(ClientStatus::Lead);
});

it('converts to array correctly', function () {
    $dto = CreateClientDTO::fromArray([
        'name'     => 'Ana',
        'email'    => 'ana@test.com',
        'document' => '44455566677',
        'status'   => 'active',
    ]);

    $array = $dto->toArray();

    expect($array)->toHaveKeys(['name', 'email', 'document', 'status', 'company_name', 'phone', 'notes']);
    expect($array['status'])->toBe('active');
});
