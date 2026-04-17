<?php

declare(strict_types=1);

use App\Enums\ClientStatus;

it('returns correct label for each status', function (ClientStatus $status, string $expectedLabel) {
    expect($status->label())->toBe($expectedLabel);
})->with([
    [ClientStatus::Lead,     'Lead'],
    [ClientStatus::Active,   'Ativo'],
    [ClientStatus::Inactive, 'Inativo'],
    [ClientStatus::Canceled, 'Cancelado'],
]);

it('only active status isActive()', function () {
    expect(ClientStatus::Active->isActive())->toBeTrue();
    expect(ClientStatus::Lead->isActive())->toBeFalse();
    expect(ClientStatus::Inactive->isActive())->toBeFalse();
    expect(ClientStatus::Canceled->isActive())->toBeFalse();
});

it('can be instantiated from its string value', function () {
    expect(ClientStatus::from('active'))->toBe(ClientStatus::Active);
    expect(ClientStatus::from('lead'))->toBe(ClientStatus::Lead);
});

it('throws ValueError for unknown string value', function () {
    ClientStatus::from('unknown');
})->throws(ValueError::class);
