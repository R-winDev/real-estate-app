<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }

    public function test_admin_can_login_and_reach_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_admin_with_must_change_password_is_redirected(): void
    {
        $this->admin->update(['must_change_password' => true]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('password.force.show'));
    }

    public function test_admin_with_must_change_password_can_access_force_change_page(): void
    {
        $this->admin->update(['must_change_password' => true]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response = $this->get(route('password.force.show'));
        $response->assertOk();
    }

    public function test_admin_can_complete_force_password_change(): void
    {
        $this->admin->update(['must_change_password' => true]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response = $this->put(route('password.force.update'), [
            'password' => 'new-secure-password-123',
            'password_confirmation' => 'new-secure-password-123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'must_change_password' => false,
        ]);
    }

    public function test_admin_cannot_use_same_password_for_force_change(): void
    {
        $this->admin->update(['must_change_password' => true]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response = $this->put(route('password.force.update'), [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_admin_can_access_dashboard_after_completing_force_change(): void
    {
        $this->admin->update(['must_change_password' => true]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $this->put(route('password.force.update'), [
            'password' => 'new-secure-password-123',
            'password_confirmation' => 'new-secure-password-123',
        ]);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_admin_unverified_email_can_still_access_dashboard(): void
    {
        $this->admin->update(['email_verified_at' => null]);

        $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password',
        ]);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_regular_user_is_not_affected_by_force_password_change(): void
    {
        $regularUser = User::factory()->create([
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $this->post('/login', [
            'email' => $regularUser->email,
            'password' => 'password',
        ]);

        $response = $this->get(route('dashboard'));
        $response->assertForbidden();
    }

    public function test_admin_can_login_after_seeder_creates_account(): void
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);

        $admin = User::where('email', config('app.admin_email', 'admin@example.com'))->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => config('app.admin_password', 'password'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('password.force.show'));
    }

    public function test_admin_can_complete_full_flow_after_seeder(): void
    {
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);

        $admin = User::where('email', config('app.admin_email', 'admin@example.com'))->first();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => config('app.admin_password', 'password'),
        ]);

        $response = $this->put(route('password.force.update'), [
            'password' => 'MyNewSecure123!',
            'password_confirmation' => 'MyNewSecure123!',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->post('/logout');
        $this->assertGuest();

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'MyNewSecure123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }
}
