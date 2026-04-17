<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 year', 'now');
        $end   = fake()->dateTimeBetween($start, '+2 years');

        return [
            'client_id'  => Client::factory(),
            'file_path'  => null,
            'start_date' => $start->format('Y-m-d'),
            'end_date'   => $end->format('Y-m-d'),
            'value'      => fake()->randomFloat(2, 500, 50000),
            'status'     => fake()->randomElement([ContractStatus::Active, ContractStatus::Draft])->value,
            'notes'      => fake()->optional(0.4)->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => ContractStatus::Active->value]);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => ContractStatus::Draft->value]);
    }
}
