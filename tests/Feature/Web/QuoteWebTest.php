<?php

declare(strict_types=1);

use App\Enums\QuoteStatus;
use App\Models\Client;
use App\Models\Quote;

// ── Helpers ───────────────────────────────────────────────────────

function validQuotePayload(int $clientId, array $overrides = []): array
{
    return array_merge([
        'client_id'           => $clientId,
        'valid_until'         => now()->addDays(30)->toDateString(),
        'items'               => [
            [
                'description' => 'Desenvolvimento de sistema',
                'quantity'    => 2,
                'unit_price'  => 1500,
                'discount'    => 0,
                'product_id'  => '',
                'service_id'  => '',
            ],
        ],
    ], $overrides);
}

// ── Index ─────────────────────────────────────────────────────────

it('[web] lista orçamentos para usuário autenticado', function () {
    $user = adminUser();
    Quote::factory()->count(3)->create();

    $this->actingAs($user)
        ->get(route('quotes.index'))
        ->assertOk()
        ->assertSeeText('Orçamentos');
});

it('[web] redireciona para login se não autenticado', function () {
    $this->get(route('quotes.index'))
        ->assertRedirect(route('login'));
});

// ── Create ────────────────────────────────────────────────────────

it('[web] exibe formulário de criação', function () {
    $this->actingAs(adminUser())
        ->get(route('quotes.create'))
        ->assertOk()
        ->assertSeeText('Novo Orçamento');
});

// ── Store ─────────────────────────────────────────────────────────

it('[web] cria orçamento e calcula totais', function () {
    $user   = adminUser();
    $client = Client::factory()->active()->create();

    $response = $this->actingAs($user)
        ->post(route('quotes.store'), validQuotePayload($client->id));

    $quote = Quote::latest()->first();

    $response->assertRedirect(route('quotes.show', $quote->id));
    expect($quote->status)->toBe(QuoteStatus::Draft)
        ->and((float) $quote->subtotal)->toBe(3000.0)
        ->and((float) $quote->total)->toBe(3000.0);
});

it('[web] cria orçamento com desconto', function () {
    $user   = adminUser();
    $client = Client::factory()->active()->create();

    $payload = validQuotePayload($client->id, [
        'items' => [
            [
                'description' => 'Item com desconto',
                'quantity'    => 1,
                'unit_price'  => 1000,
                'discount'    => 100, // R$100 de desconto absoluto
                'product_id'  => '',
                'service_id'  => '',
            ],
        ],
    ]);

    $this->actingAs($user)->post(route('quotes.store'), $payload);

    $quote = Quote::latest()->first();
    expect((float) $quote->total)->toBe(900.0)
        ->and((float) $quote->discount_total)->toBe(100.0);
});

it('[web] valida campos obrigatórios ao criar', function () {
    $this->actingAs(adminUser())
        ->post(route('quotes.store'), [])
        ->assertSessionHasErrors(['client_id', 'valid_until', 'items']);
});

it('[web] valida que valid_until deve ser no futuro', function () {
    $client = Client::factory()->active()->create();

    $this->actingAs(adminUser())
        ->post(route('quotes.store'), validQuotePayload($client->id, [
            'valid_until' => now()->subDay()->toDateString(),
        ]))
        ->assertSessionHasErrors(['valid_until']);
});

// ── Show ──────────────────────────────────────────────────────────

it('[web] exibe detalhes do orçamento', function () {
    $quote = Quote::factory()->draft()->create();

    $this->actingAs(adminUser())
        ->get(route('quotes.show', $quote->id))
        ->assertOk()
        ->assertSeeText("Orçamento #{$quote->id}");
});

// ── Edit / Update ─────────────────────────────────────────────────

it('[web] exibe formulário de edição só para rascunho', function () {
    $quote = Quote::factory()->draft()->create();

    $this->actingAs(adminUser())
        ->get(route('quotes.edit', $quote->id))
        ->assertOk()
        ->assertSeeText('Editar');
});

it('[web] atualiza orçamento em rascunho', function () {
    $client = Client::factory()->active()->create();
    $quote  = Quote::factory()->draft()->for($client)->create();

    $payload = validQuotePayload($client->id, [
        'items' => [
            [
                'description' => 'Item atualizado',
                'quantity'    => 3,
                'unit_price'  => 200,
                'discount'    => 0,
                'product_id'  => '',
                'service_id'  => '',
            ],
        ],
    ]);

    $this->actingAs(adminUser())
        ->put(route('quotes.update', $quote->id), $payload)
        ->assertRedirect(route('quotes.show', $quote->id));

    expect((float) $quote->fresh()->total)->toBe(600.0);
});

// ── Status Transitions ────────────────────────────────────────────

it('[web] envia orçamento (draft → sent)', function () {
    $quote = Quote::factory()->draft()->create();

    $this->actingAs(adminUser())
        ->patch(route('quotes.send', $quote->id))
        ->assertRedirect();

    expect($quote->fresh()->status)->toBe(QuoteStatus::Sent);
});

it('[web] aprova orçamento (sent → approved)', function () {
    $quote = Quote::factory()->sent()->create();

    $this->actingAs(adminUser())
        ->patch(route('quotes.approve', $quote->id))
        ->assertRedirect();

    expect($quote->fresh()->status)->toBe(QuoteStatus::Approved);
});

it('[web] rejeita orçamento (sent → rejected)', function () {
    $quote = Quote::factory()->sent()->create();

    $this->actingAs(adminUser())
        ->patch(route('quotes.reject', $quote->id))
        ->assertRedirect();

    expect($quote->fresh()->status)->toBe(QuoteStatus::Rejected);
});

it('[web] não permite enviar orçamento já enviado', function () {
    $quote = Quote::factory()->sent()->create();

    $this->actingAs(adminUser())
        ->patch(route('quotes.send', $quote->id))
        ->assertSessionHasErrors();
});

// ── Delete ────────────────────────────────────────────────────────

it('[web] remove orçamento e redireciona para índice', function () {
    $quote = Quote::factory()->draft()->create();

    $this->actingAs(adminUser())
        ->delete(route('quotes.destroy', $quote->id))
        ->assertRedirect(route('quotes.index'));

    expect(Quote::find($quote->id))->toBeNull();
});
