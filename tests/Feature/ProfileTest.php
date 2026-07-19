<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // ========================
    // PROFILE EDIT PAGE
    // ========================

    public function test_profile_edit_requires_auth(): void
    {
        $response = $this->get(route('profile.edit'));

        $response->assertRedirect(route('login'));
    }

    public function test_profile_edit_returns_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
    }

    public function test_profile_edit_displays_profile_view(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertViewIs('profile.edit');
    }

    public function test_profile_edit_displays_user_info(): void
    {
        $user = User::factory()->create([
            'name' => 'علی رضایی',
            'email' => 'ali@example.com',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('علی رضایی');
        $response->assertSee('ali@example.com');
    }

    public function test_profile_edit_has_update_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('ذخیره');
    }

    public function test_profile_edit_has_password_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('بروزرسانی رمز عبور');
        $response->assertSee('رمز عبور فعلی');
    }

    public function test_profile_edit_has_delete_account_section(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertSee('حذف حساب کاربری');
    }

    // ========================
    // UPDATE PROFILE INFO
    // ========================

    public function test_update_profile_info(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'نام جدید',
            'email' => 'newemail@example.com',
        ]);

        $this->assertEquals('نام جدید', $user->fresh()->name);
        $this->assertEquals('newemail@example.com', $user->fresh()->email);
    }

    public function test_update_profile_redirects_back(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'نام جدید',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
    }

    public function test_update_profile_success_message(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'بروزرسانی شده',
            'email' => 'updated@example.com',
        ]);

        $response->assertSessionHas('status', 'profile-updated');
    }

    public function test_update_profile_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => '',
            'email' => $user->email,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_update_profile_requires_valid_email(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_update_profile_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => 'taken@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_update_profile_same_email_is_allowed(): void
    {
        $user = User::factory()->create(['email' => 'current@example.com']);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => 'current@example.com',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_update_profile_clears_email_verification(): void
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)->patch(route('profile.update'), [
            'name' => $user->name,
            'email' => 'brand-new@example.com',
        ]);

        $freshUser = $user->fresh();
        $this->assertEquals('brand-new@example.com', $freshUser->email);
        $this->assertNull($freshUser->email_verified_at);
    }

    // ========================
    // UPDATE PASSWORD
    // ========================

    public function test_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_update_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password', null, 'updatePassword');
    }

    public function test_update_password_with_mismatched_confirmation(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password', null, 'updatePassword');
    }

    public function test_update_password_requires_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('password.update'), [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password', null, 'updatePassword');
    }

    public function test_update_password_requires_new_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('password.update'), [
            'current_password' => 'old-password',
        ]);

        $response->assertSessionHasErrors('password', null, 'updatePassword');
    }

    // ========================
    // DELETE ACCOUNT
    // ========================

    public function test_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertGuest();
    }

    public function test_delete_account_redirects_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }

    public function test_delete_account_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password', null, 'userDeletion');
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_delete_account_requires_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('profile.destroy'), []);

        $response->assertSessionHasErrors('password', null, 'userDeletion');
    }

    public function test_delete_account_logs_out_user(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $this->assertGuest();
    }

    public function test_delete_account_removes_user_data(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)->delete(route('profile.destroy'), [
            'password' => 'password',
        ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseCount('users', 0);
    }
}
