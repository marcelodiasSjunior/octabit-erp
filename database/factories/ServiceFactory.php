<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => fake()->words(3, true) . ' Service',
            'type'        => fake()->randomElement(ServiceType::cases())->value,
            'base_price'  => fake()->randomFloat(2, 50, 5000),
            'setup_price' => fake()->optional(0.5)->randomFloat(2, 100, 2000),
            'description' => fake()->optional(0.6)->sentence(),
            'active'      => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['active' => false]);
    }

    public function recurring(): static
    {
        return $this->state(fn () => ['type' => ServiceType::Recurring->value]);
    }
}
