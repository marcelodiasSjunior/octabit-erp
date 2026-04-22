<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DealActivityType;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'deal_id'      => Deal::factory(),
            'user_id'      => User::factory(),
            'type'         => fake()->randomElement(DealActivityType::cases())->value,
            'title'        => fake()->sentence(4),
            'notes'        => fake()->optional()->sentence(),
            'scheduled_at' => fake()->dateTimeBetween('-2 days', '+7 days'),
            'done'         => false,
            'completed_at' => null,
        ];
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'done'         => true,
            'completed_at' => now(),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn () => [
            'done'         => false,
            'scheduled_at' => now()->subDays(3),
        ]);
    }
}
