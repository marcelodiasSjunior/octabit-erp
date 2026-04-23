<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Pipeline;
use App\Models\PipelineStage;
use Illuminate\Database\Seeder;

class PipelineSeeder extends Seeder
{
    public function run(): void
    {
        $pipelines = [
            [
                'name'   => 'Inbound',
                'stages' => [
                    ['name' => 'Novo Lead',       'type' => 'open', 'probability' => 10, 'position' => 1],
                    ['name' => 'Contato Feito',   'type' => 'open', 'probability' => 25, 'position' => 2],
                    ['name' => 'Proposta Enviada','type' => 'open', 'probability' => 50, 'position' => 3],
                    ['name' => 'Negociação',      'type' => 'open', 'probability' => 75, 'position' => 4],
                    ['name' => 'Fechado — Ganho', 'type' => 'won',  'probability' => 100,'position' => 5],
                    ['name' => 'Fechado — Perdido','type' => 'lost','probability' => 0,  'position' => 6],
                ],
            ],
            [
                'name'   => 'Outbound',
                'stages' => [
                    ['name' => 'Prospecção',      'type' => 'open', 'probability' => 10, 'position' => 1],
                    ['name' => 'Qualificação',    'type' => 'open', 'probability' => 20, 'position' => 2],
                    ['name' => 'Demonstração',    'type' => 'open', 'probability' => 40, 'position' => 3],
                    ['name' => 'Proposta',        'type' => 'open', 'probability' => 60, 'position' => 4],
                    ['name' => 'Fechado — Ganho', 'type' => 'won',  'probability' => 100,'position' => 5],
                    ['name' => 'Fechado — Perdido','type' => 'lost','probability' => 0,  'position' => 6],
                ],
            ],
            [
                'name'   => 'Renovação',
                'stages' => [
                    ['name' => 'Alerta Renovação','type' => 'open', 'probability' => 60, 'position' => 1],
                    ['name' => 'Em Negociação',   'type' => 'open', 'probability' => 80, 'position' => 2],
                    ['name' => 'Renovado',        'type' => 'won',  'probability' => 100,'position' => 3],
                    ['name' => 'Cancelado',       'type' => 'lost', 'probability' => 0,  'position' => 4],
                ],
            ],
        ];

        foreach ($pipelines as $data) {
            $pipeline = Pipeline::firstOrCreate(['name' => $data['name']], ['active' => true]);

            foreach ($data['stages'] as $stage) {
                PipelineStage::updateOrCreate(
                    ['pipeline_id' => $pipeline->id, 'name' => $stage['name']],
                    ['type' => $stage['type'], 'probability' => $stage['probability'], 'position' => $stage['position'], 'active' => true],
                );
            }
        }
    }
}
