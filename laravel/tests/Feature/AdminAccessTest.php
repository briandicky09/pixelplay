<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_the_root_url_points_at_the_admin_panel(): void
    {
        $this->get('/')->assertRedirect('/admin');
    }

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_non_admin_users_are_forbidden(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admins_reach_the_dashboard(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dasbor');
    }

    public function test_logging_out_returns_to_the_login_page(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post('/logout')
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
