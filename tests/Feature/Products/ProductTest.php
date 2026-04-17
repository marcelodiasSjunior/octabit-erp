<?php

declare(strict_types=1);

use App\Models\Product;
use App\Enums\ProductType;

// ── Index & listing ───────────────────────────────────────────────

it('lists products', function () {
    Product::factory()->count(5)->create();

    $this->actingAs(adminUser())
        ->get(route('products.index'))
        ->assertOk()
        ->assertSeeText(Product::first()->name);
});

it('filters products by type', function () {
    Product::factory()->create(['name' => 'SaaS Alpha', 'type' => ProductType::Saas]);
    Product::factory()->create(['name' => 'Licença Beta', 'type' => ProductType::License]);

    $this->actingAs(adminUser())
        ->get(route('products.index', ['type' => 'saas']))
        ->assertOk()
        ->assertSeeText('SaaS Alpha')
        ->assertDontSeeText('Licença Beta');
});

it('shows product detail', function () {
    $product = Product::factory()->create(['description' => 'Detalhe do produto']);

    $this->actingAs(adminUser())
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertSeeText('Detalhe do produto');
});

// ── Create ────────────────────────────────────────────────────────

it('shows create form', function () {
    $this->actingAs(adminUser())
        ->get(route('products.create'))
        ->assertOk()
        ->assertViewIs('products.create');
});

it('creates a product', function () {
    $this->actingAs(adminUser())
        ->post(route('products.store'), [
            'name'        => 'Plataforma SaaS',
            'type'        => 'saas',
            'price'       => '299.00',
            'description' => 'Acesso à plataforma',
            'active'      => '1',
        ])
        ->assertRedirect(route('products.index'));

    expect(Product::where('name', 'Plataforma SaaS')->exists())->toBeTrue();
});

it('validates required fields on store', function () {
    $this->actingAs(adminUser())
        ->post(route('products.store'), [])
        ->assertSessionHasErrors(['name', 'type', 'price']);
});

it('validates type must be in allowed list on store', function () {
    $this->actingAs(adminUser())
        ->post(route('products.store'), [
            'name'       => 'X',
            'type'       => 'unknown',
            'base_price' => '50',
        ])
        ->assertSessionHasErrors(['type']);
});

// ── Update ────────────────────────────────────────────────────────

it('shows edit form', function () {
    $product = Product::factory()->create();

    $this->actingAs(adminUser())
        ->get(route('products.edit', $product))
        ->assertOk()
        ->assertViewIs('products.edit');
});

it('updates a product', function () {
    $product = Product::factory()->create(['name' => 'Nome Antigo']);

    $this->actingAs(adminUser())
        ->put(route('products.update', $product), [
            'name'   => 'Nome Novo',
            'type'   => $product->type->value,
            'price'  => '199.00',
            'active' => '1',
        ])
        ->assertRedirect(route('products.show', $product->id));

    expect($product->fresh()->name)->toBe('Nome Novo');
});

it('validates required fields on update', function () {
    $product = Product::factory()->create();

    $this->actingAs(adminUser())
        ->put(route('products.update', $product), [])
        ->assertSessionHasErrors(['name', 'type', 'price']);
});

// ── Delete ────────────────────────────────────────────────────────

it('deletes a product', function () {
    $product = Product::factory()->create();

    $this->actingAs(adminUser())
        ->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    expect(Product::find($product->id))->toBeNull();
});

// ── Auth guard ────────────────────────────────────────────────────

it('unauthenticated user cannot access products', function () {
    $this->get(route('products.index'))->assertRedirect(route('login'));
});
