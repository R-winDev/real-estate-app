<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_ok(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }

    public function test_home_page_displays_welcome_view(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewIs('welcome');
    }

    public function test_home_page_has_stats(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewHas('stats');
        $stats = $response->viewData('stats');
        $this->assertArrayHasKey('total_properties', $stats);
        $this->assertArrayHasKey('total_locations', $stats);
        $this->assertArrayHasKey('total_types', $stats);
        $this->assertArrayHasKey('total_users', $stats);
    }

    public function test_home_page_has_featured_properties(): void
    {
        $response = $this->get(route('home'));

        $response->assertViewHas('featuredProperties');
    }

    public function test_home_page_displays_properties_when_exist(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->unsold()->create();
        Property::factory()->count(3)->create();

        $response = $this->get(route('home'));

        $response->assertOk();
        $properties = $response->viewData('featuredProperties');
        $this->assertCount(3, $properties);
    }

    public function test_home_page_only_shows_available_properties(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $properties = $response->viewData('featuredProperties');
        $this->assertCount(2, $properties);
    }

    public function test_home_page_stats_only_count_available_properties(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $stats = $response->viewData('stats');
        $this->assertEquals(2, $stats['total_properties']);
    }

    public function test_home_page_shows_nav_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('املاک');
    }

    public function test_home_page_shows_login_for_guest(): void
    {
        $response = $this->get(route('home'));

        $response->assertSee('ورود');
    }

    public function test_home_page_hides_dashboard_for_regular_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertDontSee('داشبورد');
    }

    public function test_home_page_shows_dashboard_for_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('home'));

        $response->assertSee('داشبورد');
    }
}
