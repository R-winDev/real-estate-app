<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $regularUser;
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->regularUser = User::factory()->create(['is_admin' => false]);

        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $this->property = Property::factory()->create();
    }

    // ========================
    // USER MODEL
    // ========================

    public function test_admin_user_is_admin(): void
    {
        $this->assertTrue($this->admin->isAdmin());
    }

    public function test_regular_user_is_not_admin(): void
    {
        $this->assertFalse($this->regularUser->isAdmin());
    }

    public function test_is_admin_is_boolean_cast(): void
    {
        $this->assertIsBool($this->admin->is_admin);
    }

    // ========================
    // DASHBOARD - ADMIN ONLY
    // ========================

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_allows_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('dashboard'));

        $response->assertOk();
    }

    public function test_dashboard_rejects_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('dashboard'));

        $response->assertForbidden();
    }

    public function test_dashboard_shows_stats_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats');
    }

    // ========================
    // PROPERTY CREATE - ADMIN ONLY
    // ========================

    public function test_create_requires_auth(): void
    {
        $response = $this->get(route('properties.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_create_allows_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));

        $response->assertOk();
    }

    public function test_create_rejects_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.create'));

        $response->assertForbidden();
    }

    // ========================
    // PROPERTY STORE - ADMIN ONLY
    // ========================

    public function test_store_rejects_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->post(route('properties.store'), [
            'title' => 'ملک تست',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseCount('properties', 1);
    }

    public function test_store_allows_admin(): void
    {
        $location = Location::first();
        $type = PropertyType::first();
        $status = PropertyStatus::first();

        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک ادمین',
            'price' => 5000000000,
            'type_id' => $type->id,
            'status_id' => $status->id,
            'location_id' => $location->id,
            'owner_id' => $this->admin->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', ['title' => 'ملک ادمین']);
    }

    // ========================
    // PROPERTY EDIT - ADMIN ONLY
    // ========================

    public function test_edit_requires_auth(): void
    {
        $response = $this->get(route('properties.edit', $this->property));

        $response->assertRedirect(route('login'));
    }

    public function test_edit_allows_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.edit', $this->property));

        $response->assertOk();
    }

    public function test_edit_rejects_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.edit', $this->property));

        $response->assertForbidden();
    }

    // ========================
    // PROPERTY UPDATE - ADMIN ONLY
    // ========================

    public function test_update_rejects_regular_user(): void
    {
        $originalTitle = $this->property->title;

        $response = $this->actingAs($this->regularUser)->patch(route('properties.update', $this->property), [
            'title' => 'تغییر غیرمجاز',
        ]);

        $response->assertForbidden();
        $this->assertEquals($originalTitle, $this->property->fresh()->title);
    }

    public function test_update_allows_admin(): void
    {
        $response = $this->actingAs($this->admin)->patch(route('properties.update', $this->property), [
            'title' => 'بروزرسانی توسط ادمین',
            'price' => 100000,
        ]);

        $response->assertRedirect();
        $this->assertEquals('بروزرسانی توسط ادمین', $this->property->fresh()->title);
    }

    // ========================
    // PROPERTY DESTROY - ADMIN ONLY
    // ========================

    public function test_destroy_rejects_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->delete(route('properties.destroy', $this->property));

        $response->assertForbidden();
        $this->assertDatabaseHas('properties', ['id' => $this->property->id]);
    }

    public function test_destroy_allows_admin(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('properties.destroy', $this->property));

        $response->assertRedirect(route('properties.index'));
        $this->assertDatabaseMissing('properties', ['id' => $this->property->id]);
    }

    // ========================
    // PROPERTY INDEX & SHOW - PUBLIC
    // ========================

    public function test_index_is_public(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertOk();
    }

    public function test_show_is_public(): void
    {
        $response = $this->get(route('properties.show', $this->property));

        $response->assertOk();
    }

    // ========================
    // VIEW BUTTONS - ADMIN ONLY
    // ========================

    public function test_show_hides_edit_button_for_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.show', $this->property));

        $response->assertDontSee('ویرایش');
        $response->assertDontSee('حذف');
    }

    public function test_show_displays_edit_button_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.show', $this->property));

        $response->assertSee('ویرایش');
        $response->assertSee('حذف');
    }

    public function test_index_hides_create_button_for_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.index'));

        $response->assertDontSee('افزودن ملک');
    }

    public function test_index_displays_create_button_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.index'));

        $response->assertSee('افزودن ملک');
    }

    public function test_navigation_hides_dashboard_for_regular_user(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.index'));

        $response->assertDontSee('داشبورد');
    }

    public function test_navigation_shows_dashboard_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.index'));

        $response->assertSee('داشبورد');
    }
}
