<?php

namespace Tests\Feature;

use App\Models\Game;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_seeder_creates_the_expected_catalog(): void
    {
        $this->assertSame([
            'Cyberpunk 2077',
            'Forza Horizon 6',
            'GTA 6',
            'Osu!',
            'Red Dead Redemption 2',
            'Warcraft III: Reign of Chaos',
        ], Game::orderBy('title')->pluck('title')->all());
    }

    public function test_every_seeded_cover_file_exists_in_public(): void
    {
        foreach (Game::pluck('cover_image') as $cover) {
            $this->assertFileExists(public_path('images/games/'.$cover));
        }
    }

    public function test_every_seeded_game_has_a_category_and_platforms(): void
    {
        foreach (Game::with('platforms')->get() as $game) {
            $this->assertNotNull($game->category);
            $this->assertNotEmpty($game->platforms);
        }
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed();

        $this->assertSame(6, Game::count());
    }

    public function test_admin_can_sign_in_with_the_documented_credentials(): void
    {
        $this->post('/login', [
            'email' => AdminUserSeeder::EMAIL,
            'password' => AdminUserSeeder::PASSWORD,
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();
    }
}
