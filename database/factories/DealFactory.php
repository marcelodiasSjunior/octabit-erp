<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Pipeline;
use App\Models\PipelineStage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'pipeline_id' => Pipeline::factory(),
            'stage_id' => PipelineStage::factory(),
            'title' => fake()->sentence(3),
            'value' => fake()->randomFloat(2, 500, 30000),
            'status' => DealStatus::Open,
            'expected_close_date' => fake()->dateTimeBetween('+7 days', '+90 days')->format('Y-m-d'),
            'closed_at' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
