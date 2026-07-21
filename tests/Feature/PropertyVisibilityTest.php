<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private Location $location;
    private PropertyType $type;

    protected function setUp(): void
    {
        parent::setUp();
        $this->location = Location::factory()->create();
        $this->type = PropertyType::factory()->create();
    }

    private function createStatus(string $slug): PropertyStatus
    {
        return PropertyStatus::factory()->create(['slug' => $slug]);
    }

    public function test_unsold_status_must_exist_in_database(): void
    {
        $this->createStatus('unsold');
        $this->createStatus('sold');
        $this->createStatus('blacklisted');

        $unsold = PropertyStatus::where('slug', 'unsold')->first();
        $this->assertNotNull($unsold);
        $this->assertEquals('unsold', $unsold->slug);
    }

    public function test_guest_index_only_shows_unsold_status_properties(): void
    {
        $unsold = $this->createStatus('unsold');
        $sold = $this->createStatus('sold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->create(['status_id' => $unsold->id, 'title' => 'Available Property']);
        Property::factory()->create(['status_id' => $sold->id, 'title' => 'Sold Property']);
        Property::factory()->create(['status_id' => $blacklisted->id, 'title' => 'Blacklisted Property']);

        $response = $this->get(route('properties.index'));
        $response->assertOk();

        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();

        $this->assertContains('Available Property', $titles);
        $this->assertNotContains('Sold Property', $titles);
        $this->assertNotContains('Blacklisted Property', $titles);
        $this->assertCount(1, $properties);
    }

    public function test_guest_index_shows_nothing_when_no_unsold_status_exists(): void
    {
        $sold = $this->createStatus('sold');
        Property::factory()->create(['status_id' => $sold->id, 'title' => 'Some Sold Property']);

        $response = $this->get(route('properties.index'));
        $response->assertOk();

        $properties = $response->viewData('properties');
        $this->assertCount(0, $properties);
    }

    public function test_regular_user_index_only_shows_unsold_status_properties(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $unsold = $this->createStatus('unsold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->create(['status_id' => $unsold->id, 'title' => 'Available']);
        Property::factory()->create(['status_id' => $blacklisted->id, 'title' => 'Blacklisted']);

        $response = $this->actingAs($user)->get(route('properties.index'));
        $response->assertOk();

        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();

        $this->assertContains('Available', $titles);
        $this->assertNotContains('Blacklisted', $titles);
    }

    public function test_guest_cannot_bypass_filter_via_status_id_param(): void
    {
        $unsold = $this->createStatus('unsold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->create(['status_id' => $unsold->id, 'title' => 'Available']);
        Property::factory()->create(['status_id' => $blacklisted->id, 'title' => 'Blacklisted']);

        $response = $this->get(route('properties.index', ['status_id' => $blacklisted->id]));
        $response->assertOk();

        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();

        $this->assertNotContains('Blacklisted', $titles);
    }

    public function test_guest_can_view_unsold_property(): void
    {
        $unsold = $this->createStatus('unsold');
        $property = Property::factory()->create(['status_id' => $unsold->id]);

        $response = $this->get(route('properties.show', $property));
        $response->assertOk();
    }

    public function test_guest_cannot_view_sold_property(): void
    {
        $sold = $this->createStatus('sold');
        $property = Property::factory()->create(['status_id' => $sold->id]);

        $response = $this->get(route('properties.show', $property));
        $response->assertNotFound();
    }

    public function test_guest_cannot_view_blacklisted_property(): void
    {
        $blacklisted = $this->createStatus('blacklisted');
        $property = Property::factory()->create(['status_id' => $blacklisted->id]);

        $response = $this->get(route('properties.show', $property));
        $response->assertNotFound();
    }

    public function test_guest_cannot_view_property_with_null_status(): void
    {
        $property = Property::factory()->create(['status_id' => null]);

        $response = $this->get(route('properties.show', $property));
        $response->assertNotFound();
    }

    public function test_regular_user_cannot_view_blacklisted_property(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $blacklisted = $this->createStatus('blacklisted');
        $property = Property::factory()->create(['status_id' => $blacklisted->id]);

        $response = $this->actingAs($user)->get(route('properties.show', $property));
        $response->assertNotFound();
    }

    public function test_admin_can_view_any_property(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $blacklisted = $this->createStatus('blacklisted');
        $property = Property::factory()->create(['status_id' => $blacklisted->id]);

        $response = $this->actingAs($admin)->get(route('properties.show', $property));
        $response->assertOk();
    }

    public function test_welcome_only_shows_unsold_featured_properties(): void
    {
        $unsold = $this->createStatus('unsold');
        $sold = $this->createStatus('sold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->create(['status_id' => $unsold->id, 'title' => 'Featured Available']);
        Property::factory()->create(['status_id' => $sold->id, 'title' => 'Featured Sold']);
        Property::factory()->create(['status_id' => $blacklisted->id, 'title' => 'Featured Blacklisted']);

        $response = $this->get(route('home'));
        $response->assertOk();

        $featured = $response->viewData('featuredProperties');
        $titles = $featured->pluck('title')->toArray();

        $this->assertContains('Featured Available', $titles);
        $this->assertNotContains('Featured Sold', $titles);
        $this->assertNotContains('Featured Blacklisted', $titles);
    }

    public function test_welcome_stats_count_only_unsold(): void
    {
        $unsold = $this->createStatus('unsold');
        $sold = $this->createStatus('sold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->count(2)->create(['status_id' => $unsold->id]);
        Property::factory()->create(['status_id' => $sold->id]);
        Property::factory()->create(['status_id' => $blacklisted->id]);

        $response = $this->get(route('home'));
        $stats = $response->viewData('stats');

        $this->assertEquals(2, $stats['total_properties']);
    }

    public function test_admin_index_sees_all_statuses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $unsold = $this->createStatus('unsold');
        $sold = $this->createStatus('sold');
        $blacklisted = $this->createStatus('blacklisted');

        Property::factory()->create(['status_id' => $unsold->id]);
        Property::factory()->create(['status_id' => $sold->id]);
        Property::factory()->create(['status_id' => $blacklisted->id]);

        $response = $this->actingAs($admin)->get(route('properties.index'));
        $properties = $response->viewData('properties');
        $this->assertCount(3, $properties);
    }

    public function test_admin_filter_dropdown_shows_all_statuses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->createStatus('unsold');
        $this->createStatus('sold');
        $this->createStatus('blacklisted');

        $response = $this->actingAs($admin)->get(route('properties.index'));
        $propertyStatuses = $response->viewData('propertyStatuses');
        $this->assertCount(3, $propertyStatuses);
    }

    public function test_guest_filter_dropdown_shows_only_unsold(): void
    {
        $this->createStatus('unsold');
        $this->createStatus('sold');
        $this->createStatus('blacklisted');

        $response = $this->get(route('properties.index'));
        $propertyStatuses = $response->viewData('propertyStatuses');
        $this->assertCount(1, $propertyStatuses);
        $this->assertEquals('unsold', $propertyStatuses->first()->slug);
    }
}
