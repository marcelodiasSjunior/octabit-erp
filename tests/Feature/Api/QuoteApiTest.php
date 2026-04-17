<?php

declare(strict_types=1);

use App\Enums\QuoteStatus;
use App\Models\Client;
use App\Models\Quote;

it('creates a quote via api and calculates totals', function () {
    $client = Client::factory()->active()->create();

    $response = $this->postJson('/api/quotes', [
        'client_id' => $client->id,
        'valid_until' => now()->addDays(15)->toDateString(),
        'items' => [
            [
                'description' => 'Implementacao',
                'quantity' => 2,
                'unit_price' => 500,
                'discount' => 100,
            ],
        ],
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('subtotal', '1000.00')
        ->assertJsonPath('discount_total', '100.00')
        ->assertJsonPath('total', '900.00');
});

it('lists quotes via api', function () {
    Quote::factory()->count(3)->create();

    $this->getJson('/api/quotes')
        ->assertOk()
        ->assertJsonStructure(['data', 'total', 'per_page', 'current_page']);
});

it('updates quote via api', function () {
    $quote = Quote::factory()->draft()->create();

    $response = $this->putJson("/api/quotes/{$quote->id}", [
        'client_id' => $quote->client_id,
        'status' => QuoteStatus::Draft->value,
        'valid_until' => now()->addDays(5)->toDateString(),
        'items' => [
            [
                'description' => 'Plano atualizado',
                'quantity' => 1,
                'unit_price' => 1200,
                'discount' => 200,
            ],
        ],
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('total', '1000.00');
});

it('transitions status and converts quote', function () {
    $quote = Quote::factory()->draft()->create();

    $this->patchJson("/api/quotes/{$quote->id}/send")
        ->assertOk()
        ->assertJsonPath('status', QuoteStatus::Sent->value);

    $this->patchJson("/api/quotes/{$quote->id}/approve")
        ->assertOk()
        ->assertJsonPath('status', QuoteStatus::Approved->value);

    $this->postJson("/api/quotes/{$quote->id}/convert-to-sale")
        ->assertOk()
        ->assertJsonPath('converted_to_sale_at', fn ($value) => !empty($value));
});

it('deletes quote via api', function () {
    $quote = Quote::factory()->create();

    $this->deleteJson("/api/quotes/{$quote->id}")
        ->assertNoContent();

    expect(Quote::find($quote->id))->toBeNull();
});
