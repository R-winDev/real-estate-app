<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLocationCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_access_locations(): void
    {
        $this->get(route('admin.locations.index'))->assertRedirect();
    }

    public function test_regular_user_cannot_access_locations(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get(route('admin.locations.index'))->assertForbidden();
    }

    public function test_admin_can_list_locations(): void
    {
        Location::create(['name' => 'Tehran', 'slug' => 'tehran']);

        $this->actingAs($this->admin)
            ->get(route('admin.locations.index'))
            ->assertOk()
            ->assertSee('Tehran');
    }

    public function test_admin_can_see_create_form(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.locations.create'))
            ->assertOk();
    }

    public function test_admin_can_store_location(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.locations.store'), [
                'name' => 'Isfahan',
                'slug' => 'isfahan',
                'latitude' => 32.6546,
                'longitude' => 51.6680,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('locations', ['name' => 'Isfahan', 'slug' => 'isfahan']);
    }

    public function test_store_generates_slug_automatically(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.locations.store'), [
                'name' => 'Shiraz',
            ]);

        $this->assertDatabaseHas('locations', ['name' => 'Shiraz', 'slug' => 'shiraz']);
    }

    public function test_admin_can_store_child_location(): void
    {
        $parent = Location::create(['name' => 'Tehran', 'slug' => 'tehran']);

        $this->actingAs($this->admin)
            ->post(route('admin.locations.store'), [
                'name' => 'Tajrish',
                'parent_id' => $parent->id,
            ]);

        $this->assertDatabaseHas('locations', ['name' => 'Tajrish', 'parent_id' => $parent->id]);
    }

    public function test_admin_can_edit_location(): void
    {
        $location = Location::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $this->actingAs($this->admin)
            ->get(route('admin.locations.edit', $location))
            ->assertOk()
            ->assertSee('Old Name');
    }

    public function test_admin_can_update_location(): void
    {
        $location = Location::create(['name' => 'Old', 'slug' => 'old']);

        $this->actingAs($this->admin)
            ->put(route('admin.locations.update', $location), [
                'name' => 'New Name',
                'slug' => 'new-name',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('locations', ['id' => $location->id, 'name' => 'New Name']);
    }

    public function test_admin_can_delete_location(): void
    {
        $location = Location::create(['name' => 'ToDelete', 'slug' => 'to-delete']);

        $this->actingAs($this->admin)
            ->delete(route('admin.locations.destroy', $location))
            ->assertRedirect();

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_store_validates_required_fields(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.locations.store'), [])
            ->assertSessionHasErrors(['name']);
    }

    public function test_store_validates_unique_slug(): void
    {
        Location::create(['name' => 'Tehran', 'slug' => 'tehran']);

        $this->actingAs($this->admin)
            ->post(route('admin.locations.store'), [
                'name' => 'Another',
                'slug' => 'tehran',
            ])
            ->assertSessionHasErrors(['slug']);
    }
}
