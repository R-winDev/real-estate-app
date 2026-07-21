<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCrudTest extends TestCase
{
    use RefreshDatabase;

    private function createPropertyData(): array
    {
        return [
            'title' => 'آپارتمان ۱۲۰ متری',
            'description' => 'آپارتمان شیک در مرکز شهر',
            'area_total' => 120,
            'area_useful' => 100,
            'year_built' => 1400,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'floor' => 3,
            'total_floors' => 5,
            'price' => 5000000000,
            'address_fa' => 'تهران، خیابان ولیعصر',
            'has_parking' => true,
            'has_elevator' => true,
            'has_storage' => false,
            'has_balcony' => true,
            'has_garden' => false,
            'listing_type' => 'sale',
        ];
    }

    // ========================
    // INDEX ROUTE (GET /properties)
    // ========================

    public function test_index_returns_ok(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertOk();
    }

    public function test_index_displays_index_view(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertViewIs('properties.index');
    }

    public function test_index_is_public(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $this->assertGuest();
    }

    public function test_index_shows_properties(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        Property::factory()->count(3)->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
    }

    public function test_index_shows_empty_message_when_no_properties(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertSee('ملکی یافت نشد');
    }

    public function test_index_has_search_form(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertSee('جستجو');
        $response->assertSee('search');
    }

    public function test_index_filters_by_search(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();

        Property::factory()->create(['title' => 'ویلای جنگلی']);
        Property::factory()->create(['title' => 'آپارتمان شهری']);

        $response = $this->get(route('properties.index', ['search' => 'ویلا']));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(1, $properties);
    }

    public function test_index_filters_by_type(): void
    {
        $location = Location::factory()->create();
        $type1 = PropertyType::factory()->create();
        $type2 = PropertyType::factory()->create();
        PropertyStatus::factory()->create();

        Property::factory()->create(['type_id' => $type1->id]);
        Property::factory()->create(['type_id' => $type2->id]);

        $response = $this->get(route('properties.index', ['type_id' => $type1->id]));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(1, $properties);
    }

    public function test_index_filters_by_location(): void
    {
        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();

        Property::factory()->create(['location_id' => $location1->id]);
        Property::factory()->create(['location_id' => $location2->id]);

        $response = $this->get(route('properties.index', ['location_id' => $location1->id]));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(1, $properties);
    }

    public function test_index_has_create_button_for_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('properties.index'));

        $response->assertSee('افزودن ملک');
    }

    public function test_index_hides_create_button_for_guest(): void
    {
        $response = $this->get(route('properties.index'));

        $response->assertDontSee('افزودن ملک');
    }

    // ========================
    // CREATE ROUTE (GET /properties/create)
    // ========================

    public function test_create_requires_auth(): void
    {
        $response = $this->get(route('properties.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_create_returns_ok_for_auth_user(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertOk();
    }

    public function test_create_displays_create_view(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertViewIs('properties.create');
    }

    public function test_create_has_form_with_required_fields(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertSee('ذخیره ملک');
        $response->assertSee('عنوان ملک');
        $response->assertSee('قیمت');
        $response->assertSee('آدرس');
    }

    public function test_create_has_all_field_groups(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertSee('اطلاعات پایه');
        $response->assertSee('متراژ و جزئیات');
        $response->assertSee('امکانات');
        $response->assertSee('قیمت و آدرس');
    }

    public function test_create_has_amenities_checkboxes(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertSee('پارکینگ');
        $response->assertSee('آسانسور');
        $response->assertSee('انباری');
        $response->assertSee('بالکن');
        $response->assertSee('فضای سبز');
    }

    public function test_create_loads_select_options(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create(['name' => 'تهران']);
        PropertyType::factory()->create(['name_fa' => 'آپارتمان']);
        PropertyStatus::factory()->create(['name_fa' => 'فعال']);

        $response = $this->actingAs($user)->get(route('properties.create'));

        $response->assertSee('تهران');
        $response->assertSee('آپارتمان');
        $response->assertSee('فعال');
    }

    // ========================
    // STORE ROUTE (POST /properties)
    // ========================

    public function test_store_requires_auth(): void
    {
        $response = $this->post(route('properties.store'), []);

        $response->assertRedirect(route('login'));
    }

    public function test_store_creates_property_in_database(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->create();

        $data = $this->createPropertyData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;

        $response = $this->actingAs($user)->post(route('properties.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('properties', [
            'title' => 'آپارتمان ۱۲۰ متری',
            'price' => 5000000000,
            'owner_id' => $user->id,
        ]);
    }

    public function test_store_redirects_to_show_page(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->create();

        $data = $this->createPropertyData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;

        $response = $this->actingAs($user)->post(route('properties.store'), $data);

        $property = Property::first();
        $response->assertRedirect(route('properties.show', $property));
    }

    public function test_store_success_flash_message(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->create();

        $data = $this->createPropertyData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;

        $response = $this->actingAs($user)->post(route('properties.store'), $data);

        $response->assertSessionHas('success', 'ملک با موفقیت ثبت شد');
    }

    public function test_store_increments_database_count(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();

        $this->assertDatabaseCount('properties', 0);

        $data = $this->createPropertyData();
        $data['owner_id'] = $user->id;

        $this->actingAs($user)->post(route('properties.store'), $data);

        $this->assertDatabaseCount('properties', 1);
    }

    public function test_store_validation_requires_title(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'price' => 5000000000,
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_validation_requires_valid_type_id(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'type_id' => 99999,
        ]);

        $response->assertSessionHasErrors('type_id');
    }

    public function test_store_validation_requires_valid_status_id(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'status_id' => 99999,
        ]);

        $response->assertSessionHasErrors('status_id');
    }

    public function test_store_validation_requires_valid_location_id(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'location_id' => 99999,
        ]);

        $response->assertSessionHasErrors('location_id');
    }

    public function test_store_validation_requires_valid_owner_id(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'owner_id' => 99999,
        ]);

        $response->assertSessionHasErrors('owner_id');
    }

    public function test_store_validation_price_must_be_integer(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_store_validation_bedrooms_cannot_be_negative(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'bedrooms' => -1,
        ]);

        $response->assertSessionHasErrors('bedrooms');
    }

    public function test_store_validation_fails_with_empty_data(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), []);

        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('properties', 0);
    }

    public function test_store_validates_orientation(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'orientation' => 'north-west',
        ]);

        $response->assertSessionHasErrors('orientation');
    }

    public function test_store_saves_boolean_fields_correctly(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->create();

        $data = $this->createPropertyData();
        $data['type_id'] = $type->id;
        $data['status_id'] = $status->id;
        $data['location_id'] = $location->id;
        $data['owner_id'] = $user->id;
        $data['has_parking'] = true;
        $data['has_elevator'] = false;

        $this->actingAs($user)->post(route('properties.store'), $data);

        $property = Property::first();
        $this->assertTrue($property->has_parking);
        $this->assertFalse($property->has_elevator);
    }

    // ========================
    // SHOW ROUTE (GET /properties/{property})
    // ========================

    public function test_show_returns_ok(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
    }

    public function test_show_is_public(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $this->assertGuest();
    }

    public function test_show_displays_show_view(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertViewIs('properties.show');
    }

    public function test_show_displays_property_title(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['title' => 'ویلای شمال']);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('ویلای شمال');
    }

    public function test_show_displays_property_price(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['price' => 5000000000]);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('5,000,000,000');
    }

    public function test_show_displays_amenities(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create([
            'has_parking' => true,
            'has_elevator' => false,
            'has_storage' => true,
            'has_balcony' => false,
            'has_garden' => true,
        ]);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('پارکینگ');
        $response->assertSee('انباری');
        $response->assertSee('فضای سبز');
    }

    public function test_show_displays_description(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['description' => 'توضیحات تستی ملک']);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('توضیحات تستی ملک');
    }

    public function test_show_displays_address(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['address_fa' => 'تهران، خیابان ولیعصر']);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('تهران، خیابان ولیعصر');
    }

    public function test_show_has_edit_button_for_auth_user(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->get(route('properties.show', $property));

        $response->assertSee('ویرایش');
        $response->assertSee('حذف');
    }

    public function test_show_hides_edit_button_for_guest(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertDontSee('ویرایش ملک');
    }

    public function test_show_has_back_to_list_link(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('املاک');
    }

    public function test_show_displays_location(): void
    {
        $location = Location::factory()->create(['name' => 'تهران']);
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['location_id' => $location->id]);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('تهران');
    }

    public function test_show_displays_property_details(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create([
            'area_total' => 150,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'year_built' => 1400,
            'floor' => 2,
            'total_floors' => 5,
        ]);

        $response = $this->get(route('properties.show', $property));

        $response->assertSee('مشخصات کلیدی');
        $response->assertSee('150');
    }

    // ========================
    // EDIT ROUTE (GET /properties/{property}/edit)
    // ========================

    public function test_edit_requires_auth(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->get(route('properties.edit', $property));

        $response->assertRedirect(route('login'));
    }

    public function test_edit_returns_ok_for_auth_user(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertOk();
    }

    public function test_edit_displays_edit_view(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertViewIs('properties.edit');
    }

    public function test_edit_has_form_with_property_data(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['title' => 'ملک برای ویرایش']);

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertSee('ملک برای ویرایش');
        $response->assertSee('بروزرسانی ملک');
    }

    public function test_edit_has_update_form_with_patch_method(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertSee('PATCH');
        $response->assertSee('_method');
    }

    public function test_edit_has_all_form_sections(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->get(route('properties.edit', $property));

        $response->assertSee('اطلاعات پایه');
        $response->assertSee('متراژ و جزئیات');
        $response->assertSee('امکانات');
        $response->assertSee('قیمت و آدرس');
    }

    // ========================
    // UPDATE ROUTE (PATCH /properties/{property})
    // ========================

    public function test_update_requires_auth(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->patch(route('properties.update', $property), ['title' => 'new']);

        $response->assertRedirect(route('login'));
    }

    public function test_update_changes_property_in_database(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['title' => 'عنوان قدیمی']);

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'title' => 'عنوان جدید',
            'price' => 2000000000,
        ]);

        $this->assertEquals('عنوان جدید', $property->fresh()->title);
    }

    public function test_update_redirects_to_show_page(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'title' => 'عنوان جدید',
            'price' => 100000,
        ]);

        $response->assertRedirect(route('properties.show', $property));
    }

    public function test_update_success_flash_message(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'title' => 'بروزرسانی شد',
            'price' => 100000,
        ]);

        $response->assertSessionHas('success', 'ملک با موفقیت بروزرسانی شد');
    }

    public function test_update_validates_title_when_provided(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'title' => '',
            'price' => 100000,
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_update_validates_price_must_be_integer(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'price' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_update_validates_type_id_exists(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'type_id' => 99999,
        ]);

        $response->assertSessionHasErrors('type_id');
    }

    public function test_update_partial_data(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create(['title' => 'عنوان اصلی', 'price' => 100000]);

        $response = $this->actingAs($user)->patch(route('properties.update', $property), [
            'title' => 'فقط عنوان',
        ]);

        $this->assertEquals('فقط عنوان', $property->fresh()->title);
        $this->assertEquals(100000, $property->fresh()->price);
    }

    // ========================
    // DESTROY ROUTE (DELETE /properties/{property})
    // ========================

    public function test_destroy_requires_auth(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->delete(route('properties.destroy', $property));

        $response->assertRedirect(route('login'));
    }

    public function test_destroy_deletes_property_from_database(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($user)->delete(route('properties.destroy', $property));

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    public function test_destroy_redirects_to_index(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->delete(route('properties.destroy', $property));

        $response->assertRedirect(route('properties.index'));
    }

    public function test_destroy_success_flash_message(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $response = $this->actingAs($user)->delete(route('properties.destroy', $property));

        $response->assertSessionHas('success', 'ملک با موفقیت حذف شد');
    }

    public function test_destroy_decrements_database_count(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        $this->assertDatabaseCount('properties', 1);

        $this->actingAs($user)->delete(route('properties.destroy', $property));

        $this->assertDatabaseCount('properties', 0);
    }

    // ========================
    // STATUS FILTERING (Non-admin users)
    // ========================

    public function test_guest_cannot_see_non_available_properties_in_index(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(2, $properties);
    }

    public function test_guest_cannot_see_non_available_property_show(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();
        $property = Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->get(route('properties.show', $property));

        $response->assertNotFound();
    }

    public function test_regular_user_cannot_see_non_available_properties_in_index(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $soldStatus = PropertyStatus::factory()->sold()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $soldStatus->id]);

        $response = $this->actingAs($user)->get(route('properties.index'));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(2, $properties);
    }

    public function test_regular_user_cannot_see_non_available_property_show(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        Location::factory()->create();
        PropertyType::factory()->create();
        $soldStatus = PropertyStatus::factory()->sold()->create();
        $property = Property::factory()->create(['status_id' => $soldStatus->id]);

        $response = $this->actingAs($user)->get(route('properties.show', $property));

        $response->assertNotFound();
    }

    public function test_admin_can_see_all_properties_in_index(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->actingAs($admin)->get(route('properties.index'));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(3, $properties);
    }

    public function test_admin_can_see_all_property_statuses_in_filter(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->unsold()->create();
        PropertyStatus::factory()->sold()->create();
        PropertyStatus::factory()->blacklisted()->create();

        $response = $this->actingAs($admin)->get(route('properties.index'));

        $response->assertOk();
        $propertyStatuses = $response->viewData('propertyStatuses');
        $this->assertCount(3, $propertyStatuses);
    }

    public function test_guest_only_sees_available_status_in_filter(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->sold()->create();
        PropertyStatus::factory()->unsold()->create();
        PropertyStatus::factory()->blacklisted()->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $propertyStatuses = $response->viewData('propertyStatuses');
        $this->assertCount(1, $propertyStatuses);
        $this->assertEquals('unsold', $propertyStatuses->first()->slug);
    }

    public function test_index_status_filter_ignored_for_non_admin(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        $availableStatus = PropertyStatus::factory()->unsold()->create();
        $blacklistedStatus = PropertyStatus::factory()->blacklisted()->create();

        Property::factory()->count(2)->create(['status_id' => $availableStatus->id]);
        Property::factory()->create(['status_id' => $blacklistedStatus->id]);

        $response = $this->get(route('properties.index', ['status_id' => $blacklistedStatus->id]));

        $response->assertOk();
        $properties = $response->viewData('properties');
        $this->assertCount(2, $properties);
    }
}
