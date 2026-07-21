<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_title_is_required(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), []);

        $response->assertSessionHasErrors('title');
    }

    public function test_title_must_be_string(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 12345,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_price_must_be_integer(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 'not-a-number',
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_bedrooms_cannot_be_negative(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'bedrooms' => -1,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('bedrooms');
    }

    public function test_orientation_must_be_valid(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'orientation' => 'north-west',
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('orientation');
    }

    public function test_owner_id_must_exist_in_users(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'owner_id' => 99999,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('owner_id');
    }

    public function test_valid_data_passes_validation(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 2500000000,
            'area_total' => 120.50,
            'bedrooms' => 3,
            'owner_id' => $user->id,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_area_total_must_be_numeric(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 2500000000,
            'area_total' => 'words',
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('area_total');
    }

    public function test_year_built_fail_validation(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 2500000000,
            'area_total' => 120.50,
            'year_built' => 1200,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasErrors('year_built');
    }

    /**
     * @throws \JsonException
     */
    public function test_year_built_passe_validation(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 2500000000,
            'area_total' => 120.50,
            'year_built' => 1404,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_type_id_must_exist_in_property_types(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'ملک تست',
            'price' => 2500000000,
            'type_id' => 999999,
            'listing_type' => 'sale',
        ]);
        $response->assertSessionHasErrors('type_id');
    }
}
