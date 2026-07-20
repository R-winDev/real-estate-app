<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_requires_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertForbidden();
    }

    public function test_dashboard_allows_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_dashboard_displays_dashboard_view(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertViewIs('dashboard');
    }

    public function test_dashboard_has_stats(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertViewHas('stats');
        $stats = $response->viewData('stats');
        $this->assertArrayHasKey('total', $stats);
        $this->assertArrayHasKey('active', $stats);
        $this->assertArrayHasKey('sold', $stats);
        $this->assertArrayHasKey('inactive', $stats);
    }

    public function test_dashboard_has_recent_properties(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertViewHas('recentProperties');
    }

    public function test_dashboard_shows_welcome_message(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'name' => 'علی']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertSee('علی');
        $response->assertSee('خوش آمدید');
    }

    public function test_dashboard_shows_stats_counts(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->count(3)->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        Property::factory()->count(3)->create(['is_sold' => false]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertSee('3');
    }

    public function test_dashboard_has_create_button(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertSee('ملک جدید');
    }
}
