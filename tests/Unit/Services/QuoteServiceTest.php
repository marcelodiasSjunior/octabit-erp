<?php

declare(strict_types=1);

use App\Enums\QuoteStatus;
use App\Models\Client;
use App\Models\Quote;
use App\Services\QuoteService;
use Illuminate\Validation\ValidationException;

it('calculates quote totals on create', function () {
    $client = Client::factory()->active()->create();

    $service = app(QuoteService::class);
    $quote = $service->create([
        'client_id' => $client->id,
        'valid_until' => now()->addDays(10)->toDateString(),
        'items' => [
            [
                'description' => 'Servico A',
                'quantity' => 2,
                'unit_price' => 100,
                'discount' => 10,
            ],
            [
                'description' => 'Produto B',
                'quantity' => 1,
                'unit_price' => 50,
                'discount' => 0,
            ],
        ],
    ]);

    expect((float) $quote->subtotal)->toBe(250.0)
        ->and((float) $quote->discount_total)->toBe(10.0)
        ->and((float) $quote->total)->toBe(240.0)
        ->and($quote->items)->toHaveCount(2);
});

it('approves only sent quote', function () {
    $quote = Quote::factory()->draft()->create();

    $service = app(QuoteService::class);

    expect(fn () => $service->approve($quote->id))
        ->toThrow(ValidationException::class);

    $service->markAsSent($quote->id);
    $approved = $service->approve($quote->id);

    expect($approved->status)->toBe(QuoteStatus::Approved);
});

it('converts approved quote to sale', function () {
    $quote = Quote::factory()->approved()->create([
        'converted_to_sale_at' => null,
    ]);

    $service = app(QuoteService::class);
    $converted = $service->convertToSale($quote->id);

    expect($converted->converted_to_sale_at)->not->toBeNull();
});
