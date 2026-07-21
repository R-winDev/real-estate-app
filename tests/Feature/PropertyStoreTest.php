<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertyStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Store creates a property in the database
     */
    public function test_store_creates_property_in_database(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $location = Location::factory()->create();
        $type = PropertyType::factory()->create();
        $status = PropertyStatus::factory()->create();

        $response = $this->actingAs($user)->post(
            route('properties.store'),
            [
                'title' => 'آپارتمان ۱۲۰ متری',
                'description' => 'آپارتمان شیک در مرکز شهر',
                'price' => 5000000000,
                'area_total' => 120.5,
                'bedrooms' => 3,
                'type_id' => $type->id,
                'status_id' => $status->id,
                'location_id' => $location->id,
                'owner_id' => $user->id,
                'listing_type' => 'sale',
            ]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('properties', [
            'title' => 'آپارتمان ۱۲۰ متری',
            'price' => 5000000000,
            'area_total' => 120.5,
            'bedrooms' => 3,
            'owner_id' => $user->id
        ]);
    }

    /**
     * Test: Title is required
     */
    public function test_title_is_required(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'price' => 5000000000,
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test: Validation fails with empty data
     */
    public function test_validation_fails_with_empty_data(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), []);

        $response->assertSessionHasErrors();
        $response->assertSessionMissing('success');
        $this->assertDatabaseCount('properties', 0);
    }

    /**
     * Test: Unauthenticate use cannot store
     */
    public function test_unauthenticate_user_cannot_store(): void
    {
        $response = $this->post(route('properties.store'), ['title' => 'test title']);

        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Store only saves validated fields (no mass-assignment extras)
     * @throws \JsonException
     */
    public function test_store_only_saves_validated_fields(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(
            route('properties.store'),
            [
                'title' => 'Test Property',
                'price' => 5000,
                'is_sold' => true,
                'id' => 9999,
                'listing_type' => 'sale',
            ]
        );

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property'
        ]);
        $this->assertDatabaseCount('properties', 1);
    }

    /**
     * Test: Successful store increments database count
     */
    public function test_successful_store_increments_database_count(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->assertDatabaseCount('properties', 0);

        $response = $this->actingAs($user)->post(
            route('properties.store'),
            [
                'title' => 'Test Property',
                'price' => 5000000000,
                'listing_type' => 'sale',
            ]
        );

        $this->assertDatabaseCount('properties', 1);
    }
}
