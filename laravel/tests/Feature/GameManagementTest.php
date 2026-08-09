<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GameManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_an_admin_can_create_a_game(): void
    {
        $payload = $this->payload();

        $this->post('/admin/games', $payload)->assertRedirect('/admin/games');

        $game = Game::where('slug', 'hollow-knight-silksong')->firstOrFail();

        $this->assertSame('Hollow Knight: Silksong', $game->title);
        $this->assertCount(1, $game->platforms);
        $this->assertFileExists(public_path('images/games/'.$game->cover_image));

        unlink(public_path('images/games/'.$game->cover_image));
    }

    public function test_a_cover_image_is_required_when_creating(): void
    {
        $this->post('/admin/games', ['cover' => null] + $this->payload())
            ->assertSessionHasErrors('cover');
    }

    public function test_the_slug_stays_unique(): void
    {
        $this->post('/admin/games', ['slug' => 'osu'] + $this->payload())
            ->assertSessionHasErrors('slug');
    }

    public function test_an_admin_can_update_a_game_without_replacing_the_cover(): void
    {
        $game = Game::where('slug', 'osu')->firstOrFail();

        $payload = $this->payload();
        unset($payload['cover']);

        $this->put('/admin/games/osu', [
            'title' => 'Osu! Lazer',
            'slug' => 'osu',
        ] + $payload)->assertRedirect('/admin/games');

        $game->refresh();

        $this->assertSame('Osu! Lazer', $game->title);
        $this->assertSame('osu.png', $game->cover_image);
    }

    public function test_deleting_a_game_keeps_the_seeded_cover_file(): void
    {
        $this->delete('/admin/games/osu')->assertRedirect('/admin/games');

        $this->assertDatabaseMissing('games', ['slug' => 'osu']);
        $this->assertFileExists(public_path('images/games/osu.png'));
    }

    /** @return array<string, mixed> */
    private function payload(): array
    {
        return [
            'title' => 'Hollow Knight: Silksong',
            'category_id' => Category::firstOrFail()->id,
            'platforms' => [Platform::firstOrFail()->id],
            'description' => str_repeat('Petualangan metroidvania di kerajaan Pharloom. ', 3),
            'price' => 249000,
            'rating' => 4.8,
            'released_at' => '2026-03-11',
            'cover' => UploadedFile::fake()->image('cover.jpg', 640, 360),
        ];
    }
}
