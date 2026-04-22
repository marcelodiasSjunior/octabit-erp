<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pipeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class PipelineStageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pipeline_id' => Pipeline::factory(),
            'name' => fake()->randomElement(['Qualificacao', 'Proposta', 'Negociacao']),
            'position' => fake()->numberBetween(1, 6),
            'type' => 'open',
            'probability' => fake()->numberBetween(0, 90),
            'active' => true,
        ];
    }
}
