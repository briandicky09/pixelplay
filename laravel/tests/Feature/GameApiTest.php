<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameApiTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_it_lists_games_with_absolute_cover_urls(): void
    {
        $response = $this->getJson('/api/games');

        $response->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => [['id', 'title', 'slug', 'description', 'cover_url', 'price', 'rating', 'category', 'platforms']],
                'meta' => ['current_page', 'total'],
            ]);

        $this->assertStringStartsWith('http', $response->json('data.0.cover_url'));
    }

    public function test_it_filters_by_category(): void
    {
        $this->getJson('/api/games?category=racing')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Forza Horizon 6');
    }

    public function test_it_shows_a_single_game_by_slug(): void
    {
        $this->getJson('/api/games/osu')
            ->assertOk()
            ->assertJsonPath('data.title', 'Osu!')
            ->assertJsonPath('data.price_label', 'Gratis');
    }

    public function test_it_rejects_an_unknown_filter_value(): void
    {
        $this->getJson('/api/games?category=does-not-exist')
            ->assertStatus(422)
            ->assertJsonValidationErrors('category');
    }

    public function test_it_caps_the_page_size(): void
    {
        $this->getJson('/api/games?per_page=500')
            ->assertStatus(422)
            ->assertJsonValidationErrors('per_page');
    }

    public function test_it_returns_json_for_an_unknown_game(): void
    {
        $this->getJson('/api/games/not-a-game')
            ->assertNotFound()
            ->assertJsonStructure(['message']);
    }

    public function test_it_lists_categories_and_platforms_with_game_counts(): void
    {
        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'games_count']]]);

        $this->getJson('/api/platforms')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'games_count']]]);
    }
}
