<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_access_users(): void
    {
        $this->get(route('admin.users.index'))->assertRedirect();
    }

    public function test_regular_user_cannot_access_users(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_admin_can_list_users(): void
    {
        User::factory()->create(['name' => 'Test User']);

        $this->actingAs($this->admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Test User');
    }

    public function test_admin_can_see_create_form(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.users.create'))
            ->assertOk();
    }

    public function test_admin_can_store_user(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'New User',
                'email' => 'new@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['name' => 'New User', 'email' => 'new@example.com']);
    }

    public function test_admin_can_store_admin_user(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'New Admin',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'is_admin' => '1',
            ]);

        $this->assertDatabaseHas('users', ['email' => 'admin@example.com', 'is_admin' => true]);
    }

    public function test_admin_can_store_user_with_must_change_password(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'Force Change',
                'email' => 'force@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'must_change_password' => '1',
            ]);

        $this->assertDatabaseHas('users', ['email' => 'force@example.com', 'must_change_password' => true]);
    }

    public function test_admin_can_edit_user(): void
    {
        $user = User::factory()->create(['name' => 'Edit Me']);

        $this->actingAs($this->admin)
            ->get(route('admin.users.edit', $user))
            ->assertOk()
            ->assertSee('Edit Me');
    }

    public function test_admin_can_update_user(): void
    {
        $user = User::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), [
                'name' => 'Updated Name',
                'email' => $user->email,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function test_admin_can_update_user_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), [
                'name' => $user->name,
                'email' => $user->email,
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_admin_can_toggle_admin_flag(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($this->admin)
            ->put(route('admin.users.update', $user), [
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => '1',
            ]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_admin' => true]);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('admin.users.destroy', $this->admin))
            ->assertSessionHasErrors();

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_store_validates_required_fields(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_store_validates_unique_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'Test',
                'email' => 'taken@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertSessionHasErrors(['email']);
    }

    public function test_store_validates_password_confirmation(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.users.store'), [
                'name' => 'Test',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different',
            ])
            ->assertSessionHasErrors(['password']);
    }
}
