<?php

namespace Tests\Feature;

use App\Models\ClimateSystem;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLookupCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    // ========================
    // AUTHORIZATION
    // ========================

    public function test_guest_cannot_access_lookup_index(): void
    {
        $this->get(route('admin.lookup.index', 'climate-systems'))->assertRedirect();
    }

    public function test_regular_user_cannot_access_lookup_index(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get(route('admin.lookup.index', 'climate-systems'))->assertForbidden();
    }

    public function test_admin_can_access_lookup_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.lookup.index', 'climate-systems'))->assertOk();
    }

    public function test_guest_cannot_access_lookup_create(): void
    {
        $this->get(route('admin.lookup.create', 'climate-systems'))->assertRedirect();
    }

    public function test_admin_can_access_lookup_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.lookup.create', 'climate-systems'))->assertOk();
    }

    // ========================
    // CLIMATE SYSTEMS CRUD
    // ========================

    public function test_admin_can_list_climate_systems(): void
    {
        ClimateSystem::create(['name' => 'Fan Coil', 'name_fa' => 'فن‌کویل', 'slug' => 'fan-coil']);

        $this->actingAs($this->admin)
            ->get(route('admin.lookup.index', 'climate-systems'))
            ->assertOk()
            ->assertSee('Fan Coil')
            ->assertSee('فن‌کویل');
    }

    public function test_admin_can_store_climate_system(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lookup.store', 'climate-systems'), [
                'name' => 'FCU',
                'name_fa' => 'فن‌کویل',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('climate_systems', ['name' => 'FCU', 'name_fa' => 'فن‌کویل']);
    }

    public function test_admin_can_edit_climate_system(): void
    {
        $item = ClimateSystem::create(['name' => 'Old', 'name_fa' => 'قدیم', 'slug' => 'old']);

        $this->actingAs($this->admin)
            ->get(route('admin.lookup.edit', ['climate-systems', $item->id]))
            ->assertOk()
            ->assertSee('Old');
    }

    public function test_admin_can_update_climate_system(): void
    {
        $item = ClimateSystem::create(['name' => 'Old', 'name_fa' => 'قدیم', 'slug' => 'old']);

        $this->actingAs($this->admin)
            ->put(route('admin.lookup.update', ['climate-systems', $item->id]), [
                'name' => 'New',
                'name_fa' => 'جدید',
                'slug' => 'new',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('climate_systems', ['id' => $item->id, 'name' => 'New']);
    }

    public function test_admin_can_delete_climate_system(): void
    {
        $item = ClimateSystem::create(['name' => 'ToDelete', 'name_fa' => 'حذف', 'slug' => 'to-delete']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['climate-systems', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('climate_systems', ['id' => $item->id]);
    }

    public function test_store_climate_system_validates_required_fields(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lookup.store', 'climate-systems'), [])
            ->assertSessionHasErrors(['name', 'name_fa']);
    }

    public function test_store_climate_system_generates_slug_from_name(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lookup.store', 'climate-systems'), [
                'name' => 'My System',
                'name_fa' => 'سیستم من',
            ]);

        $this->assertDatabaseHas('climate_systems', ['slug' => 'my-system']);
    }

    // ========================
    // FEATURES CRUD
    // ========================

    public function test_admin_can_store_feature_with_category(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lookup.store', 'features'), [
                'name' => 'Parking',
                'name_fa' => 'پارکینگ',
                'category' => 'amenity',
            ]);

        $this->assertDatabaseHas('features', ['name' => 'Parking', 'category' => 'amenity']);
    }

    public function test_admin_can_list_features(): void
    {
        Feature::create(['name' => 'Pool', 'name_fa' => 'استخر', 'category' => 'amenity']);

        $this->actingAs($this->admin)
            ->get(route('admin.lookup.index', 'features'))
            ->assertOk()
            ->assertSee('Pool')
            ->assertSee('استخر');
    }

    public function test_invalid_lookup_type_returns_404(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.lookup.index', 'nonexistent'))
            ->assertNotFound();
    }

    // ========================
    // PROPERTY TYPES CRUD
    // ========================

    public function test_admin_can_store_property_type(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.lookup.store', 'property-types'), [
                'name' => 'Apartment',
                'name_fa' => 'آپارتمان',
                'category' => 'residential',
            ]);

        $this->assertDatabaseHas('property_types', ['name' => 'Apartment', 'category' => 'residential']);
    }

    public function test_admin_can_delete_property_type(): void
    {
        $item = \App\Models\PropertyType::create(['name' => 'Villa', 'name_fa' => 'ویلا', 'slug' => 'villa', 'category' => 'residential']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['property-types', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('property_types', ['id' => $item->id]);
    }
}
