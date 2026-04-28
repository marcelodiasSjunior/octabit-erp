<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_tag(): void
    {
        $tagData = [
            'name' => 'High Priority',
            'slug' => 'high-priority',
            'color' => '#FF0000',
            'description' => 'Important leads',
        ];

        $tag = Tag::create($tagData);

        $this->assertDatabaseHas('tags', $tagData);
        $this->assertEquals('High Priority', $tag->name);
    }

    public function test_can_associate_tag_to_client(): void
    {
        $client = Client::factory()->create();
        $tag = Tag::create([
            'name' => 'Hot Lead',
            'slug' => 'hot-lead',
            'color' => '#FFA500',
        ]);

        $client->tags()->attach($tag->id);

        $this->assertCount(1, $client->tags);
        $this->assertTrue($client->tags->contains($tag));
        $this->assertDatabaseHas('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $client->id,
            'taggable_type' => Client::class,
        ]);
    }

    public function test_can_list_clients_filtered_by_tag(): void
    {
        $tagHot = Tag::create(['name' => 'Hot', 'slug' => 'hot', 'color' => '#FF0000']);
        $tagCold = Tag::create(['name' => 'Cold', 'slug' => 'cold', 'color' => '#0000FF']);

        $clientHot = Client::factory()->create();
        $clientCold = Client::factory()->create();

        $clientHot->tags()->attach($tagHot->id);
        $clientCold->tags()->attach($tagCold->id);

        $filteredClients = Client::whereHas('tags', function ($query) use ($tagHot) {
            $query->where('tags.id', $tagHot->id);
        })->get();

        $this->assertCount(1, $filteredClients);
        $this->assertTrue($filteredClients->contains($clientHot));
        $this->assertFalse($filteredClients->contains($clientCold));
    }

    public function test_can_dissociate_tag_from_client(): void
    {
        $client = Client::factory()->create();
        $tag = Tag::create(['name' => 'Test Tag', 'slug' => 'test-tag', 'color' => '#000000']);

        $client->tags()->attach($tag->id);
        $this->assertCount(1, $client->tags);

        $client->tags()->detach($tag->id);
        
        // Refresh the relationship
        $client->load('tags');
        $this->assertCount(0, $client->tags);
        $this->assertDatabaseMissing('taggables', [
            'tag_id' => $tag->id,
            'taggable_id' => $client->id,
            'taggable_type' => Client::class,
        ]);
    }
}
