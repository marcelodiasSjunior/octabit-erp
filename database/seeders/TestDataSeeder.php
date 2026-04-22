<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\DealStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealActivity;
use App\Models\DealFollowupWebhook;
use App\Models\Pipeline;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Base seeders used by tests and local QA runs.
        $this->call([
            UserSeeder::class,
            TestUserSeeder::class,
            PipelineSeeder::class,
            FollowupSLASeeder::class,
            FollowupRuleSeeder::class,
        ]);

        $client = Client::updateOrCreate(
            ['email' => 'cliente.teste@octabit.tech'],
            [
                'name' => 'Cliente Teste QA',
                'company_name' => 'QA Company LTDA',
                'document' => '11122233344',
                'phone' => '(11) 99999-0000',
                'status' => ClientStatus::Active,
                'notes' => 'Cliente criado por TestDataSeeder.',
            ]
        );

        $pipeline = Pipeline::query()->where('name', 'Inbound')->first() ?? Pipeline::query()->first();
        $stage = $pipeline?->stages()->where('type', 'open')->orderBy('position')->first();

        if (!$pipeline || !$stage) {
            return;
        }

        $deal = Deal::updateOrCreate(
            ['title' => 'Deal Teste Automatizado', 'client_id' => $client->id],
            [
                'pipeline_id' => $pipeline->id,
                'stage_id' => $stage->id,
                'value' => 10000,
                'status' => DealStatus::Open,
                'expected_close_date' => now()->addDays(30)->toDateString(),
                'closed_at' => null,
                'notes' => 'Deal de cenário para validações locais e testes manuais.',
            ]
        );

        DealActivity::firstOrCreate(
            [
                'deal_id' => $deal->id,
                'title' => 'Follow-up inicial de teste',
            ],
            [
                'user_id' => null,
                'type' => 'task',
                'notes' => 'Atividade de referência criada pelo TestDataSeeder.',
                'scheduled_at' => now()->addDay(),
                'done' => false,
                'completed_at' => null,
            ]
        );

        DealFollowupWebhook::firstOrCreate(
            [
                'name' => 'Webhook QA violation.created',
            ],
            [
                'event' => 'violation.created',
                'url' => 'https://example.com/hooks/qa-violation-created',
                'secret' => 'qa-secret-created',
                'active' => true,
            ]
        );

        DealFollowupWebhook::firstOrCreate(
            [
                'name' => 'Webhook QA violation.escalated',
            ],
            [
                'event' => 'violation.escalated',
                'url' => 'https://example.com/hooks/qa-violation-escalated',
                'secret' => 'qa-secret-escalated',
                'active' => true,
            ]
        );
    }
}
