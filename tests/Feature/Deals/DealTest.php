<?php

declare(strict_types=1);

use App\Enums\DealStatus;
use App\Enums\ClientStatus;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealStageHistory;
use App\Models\Pipeline;
use App\Models\PipelineStage;

it('lists deals', function () {
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create(['pipeline_id' => $pipeline->id]);

    Deal::factory()->count(3)->create(['pipeline_id' => $pipeline->id, 'stage_id' => $stage->id]);

    $this->actingAs(adminUser())
        ->get(route('deals.index'))
        ->assertOk()
        ->assertViewIs('deals.index');
});

it('creates a deal', function () {
    $client = Client::factory()->active()->create();
    $pipeline = Pipeline::factory()->create();
    $stage = PipelineStage::factory()->create([
        'pipeline_id' => $pipeline->id,
        'position' => 1,
        'type' => 'open',
        'probability' => 10,
    ]);

    $this->actingAs(adminUser())
        ->post(route('deals.store'), [
            'client_id' => $client->id,
            'pipeline_id' => $pipeline->id,
            'stage_id' => $stage->id,
            'title' => 'Implantacao ERP Alpha',
            'value' => '3500.00',
            'expected_close_date' => now()->addDays(20)->toDateString(),
            'notes' => 'Primeiro contato validado',
        ])
        ->assertRedirect(route('deals.index'));

    expect(Deal::where('title', 'Implantacao ERP Alpha')->exists())->toBeTrue();

    $deal = Deal::where('title', 'Implantacao ERP Alpha')->firstOrFail();

    expect(DealStageHistory::where('deal_id', $deal->id)->count())->toBe(1)
        ->and(DealStageHistory::where('deal_id', $deal->id)->first()?->to_stage_id)->toBe($stage->id);
});

    it('shows only lead and active clients on deal create form', function () {
        $lead = Client::factory()->create(['name' => 'Lead Option', 'company_name' => null, 'status' => ClientStatus::Lead]);
        $active = Client::factory()->create(['name' => 'Active Option', 'company_name' => null, 'status' => ClientStatus::Active]);
        $inactive = Client::factory()->create(['name' => 'Inactive Hidden', 'company_name' => null, 'status' => ClientStatus::Inactive]);

        $this->actingAs(adminUser())
        ->get(route('deals.create'))
        ->assertOk()
        ->assertSee($lead->name)
        ->assertSee($active->name)
        ->assertDontSee($inactive->name);
    });

it('moves deal stage and marks as won when stage type is won', function () {
    $pipeline = Pipeline::factory()->create();
    $openStage = PipelineStage::factory()->create([
        'pipeline_id' => $pipeline->id,
        'position' => 1,
        'type' => 'open',
        'probability' => 30,
    ]);
    $wonStage = PipelineStage::factory()->create([
        'pipeline_id' => $pipeline->id,
        'position' => 2,
        'type' => 'won',
        'probability' => 100,
    ]);

    $deal = Deal::factory()->create([
        'pipeline_id' => $pipeline->id,
        'stage_id' => $openStage->id,
        'status' => DealStatus::Open,
    ]);

    $this->actingAs(adminUser())
        ->patch(route('deals.move-stage', $deal), ['stage_id' => $wonStage->id])
        ->assertRedirect(route('deals.show', $deal->id));

    $deal->refresh();

    expect($deal->stage_id)->toBe($wonStage->id)
        ->and($deal->status)->toBe(DealStatus::Won)
        ->and($deal->closed_at)->not->toBeNull();

    $histories = DealStageHistory::where('deal_id', $deal->id)->orderBy('id')->get();

    expect($histories)->toHaveCount(2)
        ->and($histories->first()->exited_at)->not->toBeNull()
        ->and($histories->last()->from_stage_id)->toBe($openStage->id)
        ->and($histories->last()->to_stage_id)->toBe($wonStage->id)
        ->and($histories->last()->was_won_or_lost)->toBeTrue();
});

it('validates that stage belongs to the same pipeline on stage move', function () {
    $pipelineA = Pipeline::factory()->create();
    $pipelineB = Pipeline::factory()->create();

    $stageA = PipelineStage::factory()->create(['pipeline_id' => $pipelineA->id]);
    $stageB = PipelineStage::factory()->create(['pipeline_id' => $pipelineB->id]);

    $deal = Deal::factory()->create([
        'pipeline_id' => $pipelineA->id,
        'stage_id' => $stageA->id,
    ]);

    $this->actingAs(adminUser())
        ->from(route('deals.show', $deal))
        ->patch(route('deals.move-stage', $deal), ['stage_id' => $stageB->id])
        ->assertSessionHasErrors(['stage_id']);
});

it('unauthenticated user cannot access deals', function () {
    $this->get(route('deals.index'))->assertRedirect(route('login'));
});
