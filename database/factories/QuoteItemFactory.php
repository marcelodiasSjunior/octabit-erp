<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteItemFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 1, 10);
        $unitPrice = fake()->randomFloat(2, 50, 1000);
        $lineSubtotal = round($quantity * $unitPrice, 2);
        $discount = fake()->randomFloat(2, 0, min(100, $lineSubtotal));

        return [
            'quote_id' => Quote::factory(),
            'product_id' => null,
            'service_id' => null,
            'description' => fake()->sentence(3),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount' => $discount,
            'line_subtotal' => $lineSubtotal,
            'line_total' => round($lineSubtotal - $discount, 2),
        ];
    }
}
