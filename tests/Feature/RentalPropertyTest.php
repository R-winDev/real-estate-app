<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalPropertyTest extends TestCase
{
    use RefreshDatabase;

    private function createRentalData(): array
    {
        return [
            'title' => 'آپارتمان اجاره‌ای',
            'listing_type' => 'rental',
            'description' => 'آپارتمان شیک برای اجاره',
            'area_total' => 100,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'deposit_amount' => 2_000_000_000,
            'rent_amount' => 50_000_000,
            'address_fa' => 'تهران، خیابان ولیعصر',
        ];
    }

    private function createSaleData(): array
    {
        return [
            'title' => 'آپارتمان فروشی',
            'listing_type' => 'sale',
            'description' => 'آپارتمان شیک برای فروش',
            'area_total' => 120,
            'bedrooms' => 3,
            'price' => 5_000_000_000,
            'address_fa' => 'تهران، خیابان ولیعصر',
        ];
    }

    // ========================
    // MODEL TESTS
    // ========================

    public function test_property_has_listing_type_field(): void
    {
        $property = Property::factory()->create(['listing_type' => 'rental']);

        $this->assertEquals('rental', $property->listing_type);
    }

    public function test_property_has_deposit_amount_field(): void
    {
        $property = Property::factory()->create(['deposit_amount' => 2_000_000_000]);

        $this->assertEquals(2_000_000_000, $property->deposit_amount);
    }

    public function test_property_has_rent_amount_field(): void
    {
        $property = Property::factory()->create(['rent_amount' => 50_000_000]);

        $this->assertEquals(50_000_000, $property->rent_amount);
    }

    public function test_property_is_for_sale_method(): void
    {
        $property = Property::factory()->create(['listing_type' => 'sale']);

        $this->assertTrue($property->isForSale());
        $this->assertFalse($property->isForRent());
    }

    public function test_property_is_for_rent_method(): void
    {
        $property = Property::factory()->create(['listing_type' => 'rental']);

        $this->assertTrue($property->isForRent());
        $this->assertFalse($property->isForSale());
    }

    public function test_factory_for_sale_state(): void
    {
        $property = Property::factory()->forSale()->create();

        $this->assertEquals('sale', $property->listing_type);
        $this->assertNotNull($property->price);
        $this->assertNull($property->deposit_amount);
        $this->assertNull($property->rent_amount);
    }

    public function test_factory_for_rent_state(): void
    {
        $property = Property::factory()->forRent()->create();

        $this->assertEquals('rental', $property->listing_type);
        $this->assertNull($property->price);
        $this->assertNotNull($property->deposit_amount);
        $this->assertNotNull($property->rent_amount);
    }

    // ========================
    // STORE VALIDATION TESTS
    // ========================

    public function test_store_requires_listing_type(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
        ]);

        $response->assertSessionHasErrors('listing_type');
    }

    public function test_store_validates_listing_type_values(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'listing_type' => 'invalid',
        ]);

        $response->assertSessionHasErrors('listing_type');
    }

    public function test_store_accepts_sale_listing_type(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->unsold()->create();

        $data = $this->createSaleData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;

        $response = $this->actingAs($user)->post(route('properties.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', ['listing_type' => 'sale']);
    }

    public function test_store_accepts_rental_listing_type(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->availableForRent()->create();

        $data = $this->createRentalData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;

        $response = $this->actingAs($user)->post(route('properties.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'listing_type' => 'rental',
            'deposit_amount' => 2_000_000_000,
            'rent_amount' => 50_000_000,
        ]);
    }

    public function test_store_validates_deposit_amount_is_integer(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'listing_type' => 'rental',
            'deposit_amount' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('deposit_amount');
    }

    public function test_store_validates_rent_amount_is_integer(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'listing_type' => 'rental',
            'rent_amount' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('rent_amount');
    }

    // ========================
    // INDEX FILTERING TESTS
    // ========================

    public function test_index_filters_by_listing_type_sale(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->unsold()->create();
        PropertyStatus::factory()->availableForRent()->create();

        Property::factory()->forSale()->create(['title' => 'Sale Property']);
        Property::factory()->forRent()->create(['title' => 'Rental Property']);

        $response = $this->actingAs($admin)->get(route('properties.index', ['listing_type' => 'sale']));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();
        $this->assertContains('Sale Property', $titles);
        $this->assertNotContains('Rental Property', $titles);
    }

    public function test_index_filters_by_listing_type_rental(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->unsold()->create();
        PropertyStatus::factory()->availableForRent()->create();

        Property::factory()->forSale()->create(['title' => 'Sale Property']);
        Property::factory()->forRent()->create(['title' => 'Rental Property']);

        $response = $this->actingAs($admin)->get(route('properties.index', ['listing_type' => 'rental']));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();
        $this->assertNotContains('Sale Property', $titles);
        $this->assertContains('Rental Property', $titles);
    }

    public function test_index_filters_by_deposit_range(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->availableForRent()->create();

        Property::factory()->forRent()->create(['deposit_amount' => 1_000_000_000, 'title' => 'Low Deposit']);
        Property::factory()->forRent()->create(['deposit_amount' => 5_000_000_000, 'title' => 'High Deposit']);

        $response = $this->actingAs($admin)->get(route('properties.index', [
            'listing_type' => 'rental',
            'min_deposit' => 2_000_000_000,
        ]));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();
        $this->assertNotContains('Low Deposit', $titles);
        $this->assertContains('High Deposit', $titles);
    }

    public function test_index_filters_by_rent_range(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->availableForRent()->create();

        Property::factory()->forRent()->create(['rent_amount' => 10_000_000, 'title' => 'Low Rent']);
        Property::factory()->forRent()->create(['rent_amount' => 100_000_000, 'title' => 'High Rent']);

        $response = $this->actingAs($admin)->get(route('properties.index', [
            'listing_type' => 'rental',
            'max_rent' => 50_000_000,
        ]));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();
        $this->assertContains('Low Rent', $titles);
        $this->assertNotContains('High Rent', $titles);
    }

    // ========================
    // VISIBILITY TESTS
    // ========================

    public function test_guest_can_view_available_for_rent_property(): void
    {
        $status = PropertyStatus::factory()->availableForRent()->create();
        $property = Property::factory()->forRent()->create(['status_id' => $status->id]);

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
    }

    public function test_guest_cannot_view_rented_out_property(): void
    {
        $status = PropertyStatus::factory()->rentedOut()->create();
        $property = Property::factory()->forRent()->create(['status_id' => $status->id]);

        $response = $this->get(route('properties.show', $property));

        $response->assertNotFound();
    }

    public function test_guest_index_shows_available_for_rent_properties(): void
    {
        $unsold = PropertyStatus::factory()->unsold()->create();
        $availableForRent = PropertyStatus::factory()->availableForRent()->create();
        $rentedOut = PropertyStatus::factory()->rentedOut()->create();

        Location::factory()->create();
        PropertyType::factory()->create();

        Property::factory()->forSale()->create(['status_id' => $unsold->id, 'title' => 'Sale Available']);
        Property::factory()->forRent()->create(['status_id' => $availableForRent->id, 'title' => 'Rental Available']);
        Property::factory()->forRent()->create(['status_id' => $rentedOut->id, 'title' => 'Rented Out']);

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $titles = $properties->pluck('title')->toArray();
        $this->assertContains('Sale Available', $titles);
        $this->assertContains('Rental Available', $titles);
        $this->assertNotContains('Rented Out', $titles);
    }

    public function test_guest_filter_dropdown_shows_rental_statuses(): void
    {
        PropertyStatus::factory()->unsold()->create();
        PropertyStatus::factory()->availableForRent()->create();
        PropertyStatus::factory()->sold()->create();
        PropertyStatus::factory()->rentedOut()->create();
        PropertyStatus::factory()->blacklisted()->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $propertyStatuses = $response->viewData('propertyStatuses');
        $slugs = $propertyStatuses->pluck('slug')->toArray();
        $this->assertContains('unsold', $slugs);
        $this->assertContains('available_for_rent', $slugs);
        $this->assertNotContains('sold', $slugs);
        $this->assertNotContains('rented_out', $slugs);
        $this->assertNotContains('blacklisted', $slugs);
    }

    // ========================
    // SHOW PAGE TESTS
    // ========================

    public function test_show_rental_property_displays_deposit_and_rent(): void
    {
        $status = PropertyStatus::factory()->availableForRent()->create();
        $property = Property::factory()->forRent()->create([
            'status_id' => $status->id,
            'deposit_amount' => 2_000_000_000,
            'rent_amount' => 50_000_000,
        ]);

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertSee('مبلغ رهن');
        $response->assertSee('اجاره ماهانه');
        $response->assertSee('2,000,000,000');
        $response->assertSee('50,000,000');
    }

    public function test_show_sale_property_displays_price(): void
    {
        $status = PropertyStatus::factory()->unsold()->create();
        $property = Property::factory()->forSale()->create([
            'status_id' => $status->id,
            'price' => 5_000_000_000,
        ]);

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertSee('قیمت');
        $response->assertSee('5,000,000,000');
    }

    public function test_show_similar_properties_same_listing_type(): void
    {
        $status = PropertyStatus::factory()->availableForRent()->create();
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();

        $property = Property::factory()->forRent()->create([
            'status_id' => $status->id,
            'location_id' => $location->id,
            'type_id' => $type->id,
        ]);

        Property::factory()->forRent()->create([
            'status_id' => $status->id,
            'location_id' => $location->id,
            'type_id' => $type->id,
        ]);

        Property::factory()->forSale()->create([
            'status_id' => PropertyStatus::factory()->unsold()->create()->id,
            'location_id' => $location->id,
            'type_id' => $type->id,
        ]);

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $similarProperties = $response->viewData('similarProperties');
        foreach ($similarProperties as $similar) {
            $this->assertEquals('rental', $similar->listing_type);
        }
    }

    // ========================
    // WELCOME PAGE TESTS
    // ========================

    public function test_welcome_shows_both_sale_and_rental_properties(): void
    {
        $unsold = PropertyStatus::factory()->unsold()->create();
        $availableForRent = PropertyStatus::factory()->availableForRent()->create();

        Location::factory()->create();
        PropertyType::factory()->create();

        Property::factory()->forSale()->create(['status_id' => $unsold->id, 'title' => 'Sale Featured']);
        Property::factory()->forRent()->create(['status_id' => $availableForRent->id, 'title' => 'Rental Featured']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $featured = $response->viewData('featuredProperties');
        $titles = $featured->pluck('title')->toArray();
        $this->assertContains('Sale Featured', $titles);
        $this->assertContains('Rental Featured', $titles);
    }

    public function test_welcome_stats_count_both_sale_and_rental(): void
    {
        $unsold = PropertyStatus::factory()->unsold()->create();
        $availableForRent = PropertyStatus::factory()->availableForRent()->create();

        Location::factory()->create();
        PropertyType::factory()->create();

        Property::factory()->forSale()->count(2)->create(['status_id' => $unsold->id]);
        Property::factory()->forRent()->create(['status_id' => $availableForRent->id]);

        $response = $this->get(route('home'));
        $stats = $response->viewData('stats');

        $this->assertEquals(3, $stats['total_properties']);
    }

    // ========================
    // DASHBOARD TESTS
    // ========================

    public function test_dashboard_shows_rental_stats(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $unsold = PropertyStatus::factory()->unsold()->create();
        $availableForRent = PropertyStatus::factory()->availableForRent()->create();
        $rentedOut = PropertyStatus::factory()->rentedOut()->create();

        Location::factory()->create();
        PropertyType::factory()->create();

        Property::factory()->forSale()->count(2)->create(['status_id' => $unsold->id]);
        Property::factory()->forRent()->create(['status_id' => $availableForRent->id]);
        Property::factory()->forRent()->create(['status_id' => $rentedOut->id]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk();
        $stats = $response->viewData('stats');
        $this->assertEquals(4, $stats['total']);
        $this->assertEquals(2, $stats['for_sale']);
        $this->assertEquals(2, $stats['for_rent']);
        $this->assertEquals(1, $stats['rental_active']);
        $this->assertEquals(1, $stats['rented_out']);
    }

    // ========================
    // EDIT/UPDATE TESTS
    // ========================

    public function test_edit_displays_listing_type_toggle(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->forRent()->create();

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertOk();
        $response->assertSee('نوع آگهی');
        $response->assertSee('فروش');
        $response->assertSee('اجاره');
    }

    public function test_create_displays_listing_type_toggle(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertOk();
        $response->assertSee('نوع آگهی');
        $response->assertSee('فروش');
        $response->assertSee('اجاره');
    }

    public function test_create_displays_rental_fields_label(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertOk();
        $response->assertSee('مبلغ رهن');
        $response->assertSee('مبلغ اجاره ماهانه');
    }

    public function test_update_changes_listing_type(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->forSale()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'listing_type' => 'rental',
            'deposit_amount' => 1_000_000_000,
            'rent_amount' => 30_000_000,
        ]);

        $this->assertEquals('rental', $property->fresh()->listing_type);
        $this->assertEquals(1_000_000_000, $property->fresh()->deposit_amount);
        $this->assertEquals(30_000_000, $property->fresh()->rent_amount);
    }
}
