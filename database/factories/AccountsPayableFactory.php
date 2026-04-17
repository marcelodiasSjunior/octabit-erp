<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountsPayableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description'  => fake()->words(4, true),
            'amount'       => fake()->randomFloat(2, 50, 10000),
            'due_date'     => fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d'),
            'payment_date' => null,
            'status'       => PaymentStatus::Pending->value,
            'category'     => fake()->randomElement(['Infraestrutura', 'Software', 'Marketing', 'RH', 'Operacional']),
            'notes'        => fake()->optional(0.3)->sentence(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'status'       => PaymentStatus::Paid->value,
            'payment_date' => now()->toDateString(),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn () => [
            'status'       => PaymentStatus::Overdue->value,
            'due_date'     => fake()->dateTimeBetween('-60 days', '-1 day')->format('Y-m-d'),
            'payment_date' => null,
        ]);
    }
}
