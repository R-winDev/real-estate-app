<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyCreateEditTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->regularUser = User::factory()->create(['is_admin' => false]);
    }

    private function seedReferences(): array
    {
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->unsold()->create();
        $owner = User::factory()->create();

        return compact('location', 'type', 'status', 'owner');
    }

    private function validPropertyData(array $refs): array
    {
        return [
            'title' => 'آپارتمان مدرن',
            'description' => 'آپارتمان شیک با امکانات کامل',
            'area_total' => 150,
            'area_useful' => 120,
            'year_built' => 1402,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'floor' => 4,
            'total_floors' => 8,
            'price' => 8500000000,
            'address_fa' => 'تهران، خیابان ولیعصر، نبش کوچه گل',
            'type_id' => $refs['type']->id,
            'status_id' => $refs['status']->id,
            'location_id' => $refs['location']->id,
            'owner_id' => $refs['owner']->id,
            'orientation' => 'south',
            'has_parking' => true,
            'has_elevator' => true,
            'has_storage' => true,
            'has_balcony' => false,
            'has_garden' => false,
            'parking_count' => 2,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'floor' => 4,
            'total_floors' => 8,
            'units_count' => 16,
            'land_length' => 20,
            'land_width' => 15,
            'land_area' => 300,
        ];
    }

    // ========================
    // AUTHORIZATION
    // ========================

    public function test_create_requires_auth(): void
    {
        $response = $this->get(route('properties.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_create_requires_admin(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('properties.create'));
        $response->assertForbidden();
    }

    public function test_store_requires_auth(): void
    {
        $response = $this->post(route('properties.store'), []);
        $response->assertRedirect(route('login'));
    }

    public function test_store_requires_admin(): void
    {
        $response = $this->actingAs($this->regularUser)->post(route('properties.store'), ['title' => 'test']);
        $response->assertForbidden();
    }

    public function test_edit_requires_auth(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->get(route('properties.edit', $property));
        $response->assertRedirect(route('login'));
    }

    public function test_edit_requires_admin(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->regularUser)->get(route('properties.edit', $property));
        $response->assertForbidden();
    }

    public function test_update_requires_auth(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->patch(route('properties.update', $property), ['title' => 'updated']);
        $response->assertRedirect(route('login'));
    }

    public function test_update_requires_admin(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->regularUser)->patch(route('properties.update', $property), ['title' => 'updated']);
        $response->assertForbidden();
    }

    // ========================
    // CREATE FORM
    // ========================

    public function test_create_returns_ok_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertOk();
    }

    public function test_create_uses_correct_view(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertViewIs('properties.create');
    }

    public function test_create_shows_page_title(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('ثبت ملک جدید');
    }

    public function test_create_shows_all_form_sections(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('اطلاعات پایه');
        $response->assertSee('متراژ و جزئیات');
        $response->assertSee('جهت ساختمان');
        $response->assertSee('امکانات');
        $response->assertSee('قیمت و آدرس');
    }

    public function test_create_shows_form_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('عنوان ملک');
        $response->assertSee('توضیحات');
        $response->assertSee('متراژ کل');
        $response->assertSee('متراژ مفید');
        $response->assertSee('سال ساخت');
        $response->assertSee('تعداد اتاق خواب');
        $response->assertSee('تعداد سرویس بهداشتی');
        $response->assertSee('طبقه');
        $response->assertSee('تعداد کل طبقات');
        $response->assertSee('قیمت (تومان)');
        $response->assertSee('آدرس کامل');
    }

    public function test_create_shows_amenities_checkboxes(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('پارکینگ');
        $response->assertSee('آسانسور');
        $response->assertSee('انباری');
        $response->assertSee('بالکن');
        $response->assertSee('فضای سبز');
    }

    public function test_create_shows_orientation_options(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('شمالی');
        $response->assertSee('جنوبی');
        $response->assertSee('شرقی');
        $response->assertSee('غربی');
    }

    public function test_create_loads_reference_data_in_selects(): void
    {
        $location = Location::factory()->create(['name' => 'تهران']);
        $type = PropertyType::factory()->create(['name_fa' => 'آپارتمان']);
        $status = PropertyStatus::factory()->unsold()->create(['name_fa' => 'موجود']);

        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('تهران');
        $response->assertSee('آپارتمان');
        $response->assertSee('موجود');
    }

    public function test_create_shows_submit_button(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('ذخیره ملک');
    }

    public function test_create_shows_back_button(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('بازگشت');
    }

    public function test_create_has_post_form_action(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSeeHtml('method="POST"');
        $response->assertSee(route('properties.store'));
    }

    public function test_create_has_land_dimension_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('طول زمین');
        $response->assertSee('عرض زمین');
        $response->assertSee('مساحت زمین');
    }

    public function test_create_has_additional_fields(): void
    {
        $response = $this->actingAs($this->admin)->get(route('properties.create'));
        $response->assertSee('تعداد پارکینگ');
        $response->assertSee('تعداد واحد');
        $response->assertSee('صاحب ملک');
        $response->assertSee('وضعیت ملک');
        $response->assertSee('نوع ملک');
        $response->assertSee('موقعیت');
    }

    // ========================
    // STORE
    // ========================

    public function test_store_creates_property(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);

        $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $this->assertDatabaseHas('properties', [
            'title' => 'آپارتمان مدرن',
            'price' => 8500000000,
            'type_id' => $refs['type']->id,
            'location_id' => $refs['location']->id,
            'status_id' => $refs['status']->id,
        ]);
    }

    public function test_store_redirects_to_show(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);

        $response = $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $property = Property::first();
        $response->assertRedirect(route('properties.show', $property));
    }

    public function test_store_shows_success_message(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);

        $response = $this->actingAs($this->admin)->post(route('properties.store'), $data);
        $response->assertSessionHas('success', 'ملک با موفقیت ثبت شد');
    }

    public function test_store_increments_database_count(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);

        $this->assertDatabaseCount('properties', 0);
        $this->actingAs($this->admin)->post(route('properties.store'), $data);
        $this->assertDatabaseCount('properties', 1);
    }

    public function test_store_with_minimal_data(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک ساده',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', ['title' => 'ملک ساده']);
    }

    public function test_store_saves_boolean_fields_true(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);
        $data['has_parking'] = true;
        $data['has_elevator'] = true;
        $data['has_storage'] = true;
        $data['has_balcony'] = true;
        $data['has_garden'] = true;
        $data['is_sold'] = false;

        $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $property = Property::first();
        $this->assertTrue($property->has_parking);
        $this->assertTrue($property->has_elevator);
        $this->assertTrue($property->has_storage);
        $this->assertTrue($property->has_balcony);
        $this->assertTrue($property->has_garden);
        $this->assertFalse($property->is_sold);
    }

    public function test_store_saves_boolean_fields_false(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);
        $data['has_parking'] = false;
        $data['has_elevator'] = false;
        $data['has_storage'] = false;
        $data['has_balcony'] = false;
        $data['has_garden'] = false;

        $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $property = Property::first();
        $this->assertFalse($property->has_parking);
        $this->assertFalse($property->has_elevator);
        $this->assertFalse($property->has_storage);
        $this->assertFalse($property->has_balcony);
        $this->assertFalse($property->has_garden);
    }

    public function test_store_saves_orientation(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);
        $data['orientation'] = 'north';

        $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $this->assertDatabaseHas('properties', ['orientation' => 'north']);
    }

    public function test_store_saves_all_numeric_fields(): void
    {
        $refs = $this->seedReferences();
        $data = $this->validPropertyData($refs);

        $this->actingAs($this->admin)->post(route('properties.store'), $data);

        $property = Property::first();
        $this->assertEquals(150, $property->area_total);
        $this->assertEquals(120, $property->area_useful);
        $this->assertEquals(1402, $property->year_built);
        $this->assertEquals(3, $property->bedrooms);
        $this->assertEquals(2, $property->bathrooms);
        $this->assertEquals(4, $property->floor);
        $this->assertEquals(8, $property->total_floors);
        $this->assertEquals(16, $property->units_count);
        $this->assertEquals(20, $property->land_length);
        $this->assertEquals(15, $property->land_width);
        $this->assertEquals(300, $property->land_area);
    }

    public function test_store_validates_title_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'price' => 1000,
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_validates_title_max_255(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_store_validates_type_id_exists(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'type_id' => 99999,
        ]);

        $response->assertSessionHasErrors('type_id');
    }

    public function test_store_validates_status_id_exists(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'status_id' => 99999,
        ]);

        $response->assertSessionHasErrors('status_id');
    }

    public function test_store_validates_location_id_exists(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'location_id' => 99999,
        ]);

        $response->assertSessionHasErrors('location_id');
    }

    public function test_store_validates_owner_id_exists(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'owner_id' => 99999,
        ]);

        $response->assertSessionHasErrors('owner_id');
    }

    public function test_store_validates_price_must_be_integer(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 'not-a-number',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_store_validates_price_non_negative(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => -100,
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_store_validates_bedrooms_non_negative(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'bedrooms' => -1,
        ]);

        $response->assertSessionHasErrors('bedrooms');
    }

    public function test_store_validates_bathrooms_non_negative(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'bathrooms' => -1,
        ]);

        $response->assertSessionHasErrors('bathrooms');
    }

    public function test_store_validates_orientation_in_list(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'orientation' => 'north-west',
        ]);

        $response->assertSessionHasErrors('orientation');
    }

    public function test_store_validates_area_total_numeric(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'area_total' => 'not-number',
        ]);

        $response->assertSessionHasErrors('area_total');
    }

    public function test_store_validates_total_floors_non_negative(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'total_floors' => -1,
        ]);

        $response->assertSessionHasErrors('total_floors');
    }

    public function test_store_validates_empty_data_fails(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), []);
        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('properties', 0);
    }

    public function test_store_validates_description_max_1024(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'description' => str_repeat('a', 1025),
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_store_validates_address_max_500(): void
    {
        $response = $this->actingAs($this->admin)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'address_fa' => str_repeat('a', 501),
        ]);

        $response->assertSessionHasErrors('address_fa');
    }

    // ========================
    // EDIT FORM
    // ========================

    public function test_edit_returns_ok_for_admin(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertOk();
    }

    public function test_edit_uses_correct_view(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertViewIs('properties.edit');
    }

    public function test_edit_shows_page_title(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'title' => 'ویلای لوکس',
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('ویرایش ملک');
        $response->assertSee('ویلای لوکس');
    }

    public function test_edit_prefills_title(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'title' => 'پنت‌هاوس طبقه آخر',
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('پنت‌هاوس طبقه آخر');
    }

    public function test_edit_prefills_description(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'description' => 'توضیحات تستی ملک',
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('توضیحات تستی ملک');
    }

    public function test_edit_prefills_price(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'price' => 12500000000,
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('12500000000');
    }

    public function test_edit_prefills_area(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'area_total' => 200,
            'area_useful' => 170,
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('200');
        $response->assertSee('170');
    }

    public function test_edit_prefills_address(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'address_fa' => 'اصفهان، نقش جهان',
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('اصفهان، نقش جهان');
    }

    public function test_edit_shows_all_form_sections(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('اطلاعات پایه');
        $response->assertSee('متراژ و جزئیات');
        $response->assertSee('جهت ساختمان');
        $response->assertSee('امکانات');
        $response->assertSee('قیمت و آدرس');
    }

    public function test_edit_shows_amenities_checkboxes(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'has_parking' => true,
            'has_elevator' => false,
            'has_storage' => true,
            'has_balcony' => false,
            'has_garden' => true,
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('پارکینگ');
        $response->assertSee('آسانسور');
        $response->assertSee('انباری');
        $response->assertSee('بالکن');
        $response->assertSee('فضای سبز');
    }

    public function test_edit_shows_orientation_options(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('شمالی');
        $response->assertSee('جنوبی');
        $response->assertSee('شرقی');
        $response->assertSee('غربی');
    }

    public function test_edit_loads_reference_data(): void
    {
        $location = Location::factory()->create(['name' => 'شیراز']);
        $type = PropertyType::factory()->create(['name_fa' => 'ویلایی']);
        $status = PropertyStatus::factory()->unsold()->create(['name_fa' => 'موجود']);
        $property = Property::factory()->create([
            'location_id' => $location->id,
            'type_id' => $type->id,
            'status_id' => $status->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('شیراز');
        $response->assertSee('ویلایی');
        $response->assertSee('موجود');
    }

    public function test_edit_shows_submit_button(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('بروزرسانی ملک');
    }

    public function test_edit_shows_back_button(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee('بازگشت');
    }

    public function test_edit_has_patch_form(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->get(route('properties.edit', $property));
        $response->assertSee(route('properties.update', $property));
        $response->assertSeeHtml('method="POST"');
        $response->assertSee('_method');
    }

    // ========================
    // UPDATE
    // ========================

    public function test_update_modifies_property(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'title' => 'عنوان قدیمی',
            'status_id' => $refs['status']->id,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => 'عنوان جدید',
        ]);

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'title' => 'عنوان جدید',
        ]);
    }

    public function test_update_redirects_to_show(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => 'بروزرسانی شده',
        ]);

        $response->assertRedirect(route('properties.show', $property));
    }

    public function test_update_shows_success_message(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => 'بروزرسانی',
        ]);

        $response->assertSessionHas('success', 'ملک با موفقیت بروزرسانی شد');
    }

    public function test_update_does_not_change_unprovided_fields(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'title' => 'ملک اصلی',
            'description' => 'توضیحات اصلی',
            'price' => 5000000000,
            'area_total' => 100,
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => 'عنوان جدید',
        ]);

        $property->refresh();
        $this->assertEquals('عنوان جدید', $property->title);
        $this->assertEquals('توضیحات اصلی', $property->description);
        $this->assertEquals(5000000000, $property->price);
        $this->assertEquals(100, $property->area_total);
    }

    public function test_update_changes_description(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'description' => 'قدیمی',
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'description' => 'جدید',
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'description' => 'جدید']);
    }

    public function test_update_changes_price(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'price' => 1000000000,
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'price' => 9999999999,
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'price' => 9999999999]);
    }

    public function test_update_changes_status(): void
    {
        $refs = $this->seedReferences();
        $soldStatus = PropertyStatus::factory()->sold()->create();
        $property = Property::factory()->create([
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'status_id' => $soldStatus->id,
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'status_id' => $soldStatus->id]);
    }

    public function test_update_changes_location(): void
    {
        $refs = $this->seedReferences();
        $newLocation = Location::factory()->create();
        $property = Property::factory()->create([
            'location_id' => $refs['location']->id,
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'location_id' => $newLocation->id,
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'location_id' => $newLocation->id]);
    }

    public function test_update_changes_type(): void
    {
        $refs = $this->seedReferences();
        $newType = PropertyType::factory()->create();
        $property = Property::factory()->create([
            'type_id' => $refs['type']->id,
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'type_id' => $newType->id,
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'type_id' => $newType->id]);
    }

    public function test_update_changes_boolean_fields(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'has_parking' => true,
            'has_elevator' => true,
            'has_storage' => true,
            'has_balcony' => true,
            'has_garden' => true,
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'has_parking' => false,
            'has_elevator' => false,
            'has_storage' => false,
            'has_balcony' => false,
            'has_garden' => false,
        ]);

        $property->refresh();
        $this->assertFalse($property->has_parking);
        $this->assertFalse($property->has_elevator);
        $this->assertFalse($property->has_storage);
        $this->assertFalse($property->has_balcony);
        $this->assertFalse($property->has_garden);
    }

    public function test_update_changes_orientation(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create([
            'orientation' => 'south',
            'status_id' => $refs['status']->id,
        ]);

        $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'orientation' => 'north',
        ]);

        $this->assertDatabaseHas('properties', ['id' => $property->id, 'orientation' => 'north']);
    }

    public function test_update_validates_title_required_when_provided(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_update_validates_type_id_exists(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'type_id' => 99999,
        ]);

        $response->assertSessionHasErrors('type_id');
    }

    public function test_update_validates_status_id_exists(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'status_id' => 99999,
        ]);

        $response->assertSessionHasErrors('status_id');
    }

    public function test_update_validates_location_id_exists(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'location_id' => 99999,
        ]);

        $response->assertSessionHasErrors('location_id');
    }

    public function test_update_validates_price_must_be_integer(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'price' => 'abc',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_update_validates_orientation_in_list(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'orientation' => 'invalid',
        ]);

        $response->assertSessionHasErrors('orientation');
    }

    public function test_update_validates_title_max_255(): void
    {
        $refs = $this->seedReferences();
        $property = Property::factory()->create(['status_id' => $refs['status']->id]);

        $response = $this->actingAs($this->admin)->patch(route('properties.update', $property), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }
}
