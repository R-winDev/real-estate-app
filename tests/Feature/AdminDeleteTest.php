<?php

namespace Tests\Feature;

use App\Models\BuildingMaterial;
use App\Models\ClimateSystem;
use App\Models\Document;
use App\Models\Feature;
use App\Models\FloorMaterial;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDeleteTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    // ========================
    // USERS
    // ========================

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_user_returns_success_flash(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertSessionHas('success', 'کاربر با موفقیت حذف شد');
    }

    public function test_guest_cannot_delete_user(): void
    {
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_non_admin_cannot_delete_user(): void
    {
        $regular = User::factory()->create(['is_admin' => false]);
        $target = User::factory()->create();

        $this->actingAs($regular)
            ->delete(route('admin.users.destroy', $target))
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $target->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $this->admin))
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    // ========================
    // LOCATIONS
    // ========================

    public function test_admin_can_delete_location(): void
    {
        $location = Location::create(['name' => 'Tehran', 'slug' => 'tehran']);

        $this->actingAs($this->admin)
            ->delete(route('admin.locations.destroy', $location))
            ->assertRedirect();

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_delete_location_returns_success_flash(): void
    {
        $location = Location::create(['name' => 'Isfahan', 'slug' => 'isfahan']);

        $this->actingAs($this->admin)
            ->delete(route('admin.locations.destroy', $location))
            ->assertSessionHas('success', 'موقعیت با موفقیت حذف شد');
    }

    public function test_guest_cannot_delete_location(): void
    {
        $location = Location::create(['name' => 'Shiraz', 'slug' => 'shiraz']);

        $this->delete(route('admin.locations.destroy', $location))
            ->assertRedirect();

        $this->assertDatabaseHas('locations', ['id' => $location->id]);
    }

    public function test_non_admin_cannot_delete_location(): void
    {
        $regular = User::factory()->create(['is_admin' => false]);
        $location = Location::create(['name' => 'Tabriz', 'slug' => 'tabriz']);

        $this->actingAs($regular)
            ->delete(route('admin.locations.destroy', $location))
            ->assertForbidden();

        $this->assertDatabaseHas('locations', ['id' => $location->id]);
    }

    // ========================
    // INQUIRIES
    // ========================

    public function test_admin_can_delete_inquiry(): void
    {
        Property::factory()->create();
        $inquiry = PropertyInquiry::create([
            'property_id' => Property::first()->id,
            'customer_name' => 'Ali',
            'customer_phone' => '09121234567',
            'inquiry_type' => 'visit_request',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertRedirect();

        $this->assertDatabaseMissing('property_inquiries', ['id' => $inquiry->id]);
    }

    public function test_delete_inquiry_returns_success_flash(): void
    {
        Property::factory()->create();
        $inquiry = PropertyInquiry::create([
            'property_id' => Property::first()->id,
            'customer_name' => 'Reza',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertSessionHas('success', 'درخواست با موفقیت حذف شد');
    }

    public function test_guest_cannot_delete_inquiry(): void
    {
        Property::factory()->create();
        $inquiry = PropertyInquiry::create([
            'property_id' => Property::first()->id,
            'customer_name' => 'Guest Test',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertRedirect();

        $this->assertDatabaseHas('property_inquiries', ['id' => $inquiry->id]);
    }

    public function test_non_admin_cannot_delete_inquiry(): void
    {
        $regular = User::factory()->create(['is_admin' => false]);
        Property::factory()->create();
        $inquiry = PropertyInquiry::create([
            'property_id' => Property::first()->id,
            'customer_name' => 'Non Admin Test',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($regular)
            ->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertForbidden();

        $this->assertDatabaseHas('property_inquiries', ['id' => $inquiry->id]);
    }

    // ========================
    // LOOKUP: CLIMATE SYSTEMS
    // ========================

    public function test_admin_can_delete_climate_system(): void
    {
        $item = ClimateSystem::create(['name' => 'FCU', 'name_fa' => 'فن‌کویل', 'slug' => 'fcu']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['climate-systems', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('climate_systems', ['id' => $item->id]);
    }

    public function test_delete_climate_system_returns_success_flash(): void
    {
        $item = ClimateSystem::create(['name' => 'AC', 'name_fa' => 'کولر', 'slug' => 'ac']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['climate-systems', $item->id]))
            ->assertSessionHas('success', 'سیستم تهویه با موفقیت حذف شد');
    }

    // ========================
    // LOOKUP: FLOOR MATERIALS
    // ========================

    public function test_admin_can_delete_floor_material(): void
    {
        $item = FloorMaterial::create(['name' => 'Tile', 'name_fa' => 'سرامیک', 'slug' => 'tile']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['floor-materials', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('floor_materials', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: BUILDING MATERIALS
    // ========================

    public function test_admin_can_delete_building_material(): void
    {
        $item = BuildingMaterial::create(['name' => 'Concrete', 'name_fa' => 'بتن', 'slug' => 'concrete']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['building-materials', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('building_materials', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: DOCUMENTS
    // ========================

    public function test_admin_can_delete_document(): void
    {
        $item = Document::create(['name' => 'Deed', 'name_fa' => 'سند', 'slug' => 'deed']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['documents', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('documents', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: FEATURES
    // ========================

    public function test_admin_can_delete_feature(): void
    {
        $item = Feature::create(['name' => 'Pool', 'name_fa' => 'استخر', 'category' => 'amenity']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['features', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('features', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: PROPERTY TYPES
    // ========================

    public function test_admin_can_delete_property_type(): void
    {
        $item = PropertyType::create(['name' => 'Villa', 'name_fa' => 'ویلا', 'slug' => 'villa', 'category' => 'residential']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['property-types', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('property_types', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: PROPERTY STATUSES
    // ========================

    public function test_admin_can_delete_property_status(): void
    {
        $item = PropertyStatus::create(['name' => 'Draft', 'name_fa' => 'پیش‌نویس', 'slug' => 'draft']);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['property-statuses', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseMissing('property_statuses', ['id' => $item->id]);
    }

    // ========================
    // LOOKUP: GUEST / NON-ADMIN
    // ========================

    public function test_guest_cannot_delete_lookup_item(): void
    {
        $item = ClimateSystem::create(['name' => 'FCU', 'name_fa' => 'فن‌کویل', 'slug' => 'fcu']);

        $this->delete(route('admin.lookup.destroy', ['climate-systems', $item->id]))
            ->assertRedirect();

        $this->assertDatabaseHas('climate_systems', ['id' => $item->id]);
    }

    public function test_non_admin_cannot_delete_lookup_item(): void
    {
        $regular = User::factory()->create(['is_admin' => false]);
        $item = Feature::create(['name' => 'Pool', 'name_fa' => 'استخر', 'category' => 'amenity']);

        $this->actingAs($regular)
            ->delete(route('admin.lookup.destroy', ['features', $item->id]))
            ->assertForbidden();

        $this->assertDatabaseHas('features', ['id' => $item->id]);
    }

    // ========================
    // PROPERTIES
    // ========================

    public function test_admin_can_delete_property(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('properties.destroy', $property))
            ->assertRedirect();

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_delete_property_returns_success_flash(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('properties.destroy', $property))
            ->assertSessionHas('success', 'ملک با موفقیت حذف شد');
    }

    public function test_guest_cannot_delete_property(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $this->delete(route('properties.destroy', $property))
            ->assertRedirect();

        $this->assertDatabaseHas('properties', ['id' => $property->id]);
    }

    // ========================
    // DELETE WITH RELATIONSHIPS
    // ========================

    public function test_delete_location_with_properties_nulls_location_id(): void
    {
        $location = Location::create(['name' => 'Tehran', 'slug' => 'tehran']);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['location_id' => $location->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.locations.destroy', $location));

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'location_id' => null]);
    }

    public function test_delete_user_with_properties_nulls_owner_id(): void
    {
        $user = User::factory()->create();
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['owner_id' => $user->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'owner_id' => null]);
    }

    public function test_delete_user_with_inquiries_nulls_customer_id(): void
    {
        $user = User::factory()->create();
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        Property::factory()->create();
        $inquiry = PropertyInquiry::create([
            'property_id' => Property::first()->id,
            'customer_id' => $user->id,
            'customer_name' => 'Test',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseHas('property_inquiries', ['id' => $inquiry->id, 'customer_id' => null]);
    }

    public function test_delete_property_type_with_properties_nulls_type_id(): void
    {
        $type = PropertyType::create(['name' => 'Villa', 'name_fa' => 'ویلا', 'slug' => 'villa', 'category' => 'residential']);
        Location::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['type_id' => $type->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['property-types', $type->id]));

        $this->assertDatabaseMissing('property_types', ['id' => $type->id]);
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'type_id' => null]);
    }

    public function test_delete_property_status_with_properties_nulls_status_id(): void
    {
        $status = PropertyStatus::create(['name' => 'Draft', 'name_fa' => 'پیش‌نویس', 'slug' => 'draft']);
        Location::factory()->create();
        PropertyType::factory()->create();
        $property = Property::factory()->create(['status_id' => $status->id]);

        $this->actingAs($this->admin)
            ->delete(route('admin.lookup.destroy', ['property-statuses', $status->id]));

        $this->assertDatabaseMissing('property_statuses', ['id' => $status->id]);
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'status_id' => null]);
    }

    public function test_delete_property_detaches_pivot_relations(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $feature = Feature::create(['name' => 'Pool', 'name_fa' => 'استخر', 'category' => 'amenity']);
        $climate = ClimateSystem::create(['name' => 'FCU', 'name_fa' => 'فن‌کویل', 'slug' => 'fcu']);
        $property = Property::factory()->create();

        $property->features()->attach($feature->id);
        $property->climateSystems()->attach($climate->id);

        $this->actingAs($this->admin)
            ->delete(route('properties.destroy', $property));

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
        $this->assertDatabaseMissing('property_features', ['property_id' => $property->id, 'feature_id' => $feature->id]);
        $this->assertDatabaseMissing('property_climate_systems', ['property_id' => $property->id, 'climate_system_id' => $climate->id]);
    }
}
