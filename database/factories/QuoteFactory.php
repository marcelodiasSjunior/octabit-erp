<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 200, 5000);
        $discount = fake()->randomFloat(2, 0, min(500, $subtotal));

        return [
            'client_id' => Client::factory(),
            'status' => fake()->randomElement([
                QuoteStatus::Draft->value,
                QuoteStatus::Sent->value,
                QuoteStatus::Approved->value,
            ]),
            'valid_until' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'subtotal' => $subtotal,
            'discount_total' => $discount,
            'total' => round($subtotal - $discount, 2),
            'converted_to_sale_at' => null,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => ['status' => QuoteStatus::Approved->value]);
    }

    public function sent(): static
    {
        return $this->state(fn () => ['status' => QuoteStatus::Sent->value]);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => QuoteStatus::Draft->value]);
    }
}
