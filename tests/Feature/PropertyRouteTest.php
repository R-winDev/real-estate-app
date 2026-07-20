<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertyRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_route_changes_property(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $property = Property::factory()->create(['title' => 'old']);

        $response = $this->actingAs($user)->put("/properties/{$property->id}", ['title' => 'new', 'price' => 200000]);

        $this->assertEquals('new', $property->fresh()->title);
    }

    public function test_destroy_route_deletes_property(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $property = Property::factory()->create();

        $this->actingAs($user)->delete("/properties/{$property->id}");

        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }
}
