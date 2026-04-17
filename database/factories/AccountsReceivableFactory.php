<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountsReceivable>
 */
class AccountsReceivableFactory extends Factory
{
    public function definition(): array
    {
        $dueDate = fake()->dateTimeBetween('-2 months', '+2 months');
        $isPaid  = fake()->boolean(40);

        return [
            'client_id'    => Client::factory(),
            'description'  => fake()->sentence(4),
            'amount'       => fake()->randomFloat(2, 50, 5000),
            'due_date'     => $dueDate,
            'payment_date' => $isPaid ? fake()->dateTimeThisMonth() : null,
            'status'       => $isPaid
                ? PaymentStatus::Paid->value
                : PaymentStatus::calculate(
                    new \DateTimeImmutable($dueDate->format('Y-m-d')), null
                  )->value,
            'notes'        => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'due_date'     => now()->addDays(10)->toDateString(),
            'payment_date' => null,
            'status'       => PaymentStatus::Pending->value,
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn () => [
            'due_date'     => now()->subDays(5)->toDateString(),
            'payment_date' => null,
            'status'       => PaymentStatus::Overdue->value,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'payment_date' => now()->toDateString(),
            'status'       => PaymentStatus::Paid->value,
        ]);
    }
}
