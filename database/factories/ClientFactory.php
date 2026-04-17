<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'         => fake()->name(),
            'company_name' => fake()->optional(0.6)->company(),
            'document'     => fake()->unique()->numerify('###########'),  // 11-digit CPF
            'email'        => fake()->unique()->safeEmail(),
            'phone'        => fake()->optional(0.8)->phoneNumber(),
            'status'       => fake()->randomElement(ClientStatus::cases())->value,
            'notes'        => fake()->optional(0.3)->sentence(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => ClientStatus::Active]);
    }

    public function lead(): static
    {
        return $this->state(fn () => ['status' => ClientStatus::Lead]);
    }
}
