<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxonomyManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_a_category_slug_is_derived_from_its_name(): void
    {
        $this->post('/admin/categories', ['name' => 'Survival Horror'])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', [
            'name' => 'Survival Horror',
            'slug' => 'survival-horror',
        ]);
    }

    public function test_a_category_in_use_cannot_be_deleted(): void
    {
        $category = Category::where('slug', 'rhythm')->firstOrFail();

        $this->delete('/admin/categories/rhythm')->assertSessionHas('error');

        $this->assertModelExists($category);
    }

    public function test_an_unused_platform_can_be_deleted(): void
    {
        $platform = Platform::where('slug', 'nintendo-switch')->firstOrFail();

        $this->delete('/admin/platforms/nintendo-switch')
            ->assertRedirect('/admin/platforms');

        $this->assertModelMissing($platform);
    }

    public function test_platform_names_stay_unique(): void
    {
        $this->post('/admin/platforms', ['name' => 'PC'])
            ->assertSessionHasErrors('name');
    }
}
