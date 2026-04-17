<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->words(2, true) . ' ' . fake()->randomElement(['Pro', 'Starter', 'Enterprise', 'Plus']),
            'type'        => fake()->randomElement(ProductType::cases())->value,
            'price'       => fake()->randomFloat(2, 29, 2999),
            'description' => fake()->optional(0.6)->sentence(),
            'active'      => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['active' => false]);
    }
}
