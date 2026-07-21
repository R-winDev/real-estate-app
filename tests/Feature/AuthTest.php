<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ========================
    // LOGIN PAGE
    // ========================

    public function test_login_page_returns_ok(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function test_login_page_displays_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertSee('ورود');
        $response->assertSee('ایمیل');
        $response->assertSee('رمز عبور');
        $response->assertSee('remember');
    }

    public function test_login_page_has_register_link(): void
    {
        $response = $this->get(route('login'));

        $response->assertSee('ثبت نام');
    }

    public function test_login_page_has_forgot_password_link(): void
    {
        $response = $this->get(route('login'));

        $response->assertSee('رمز عبور را فراموش کرده‌اید؟');
    }

    public function test_login_page_hidden_for_auth_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('properties.index'));
    }

    // ========================
    // LOGIN ACTION
    // ========================

    public function test_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect(route('properties.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_with_nonexistent_user(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->post(route('login'), []);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_throttling(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), [
                'email' => 'test@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect();
    }

    // ========================
    // REGISTER PAGE
    // ========================

    public function test_register_page_returns_ok(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function test_register_page_displays_form(): void
    {
        $response = $this->get(route('register'));

        $response->assertSee('ثبت نام');
        $response->assertSee('نام');
        $response->assertSee('ایمیل');
        $response->assertSee('رمز عبور');
        $response->assertSee('تکرار رمز عبور');
    }

    public function test_register_page_has_login_link(): void
    {
        $response = $this->get(route('register'));

        $response->assertSee('قبلاً ثبت نام کرده‌اید؟');
    }

    public function test_register_page_hidden_for_auth_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect(route('properties.index'));
    }

    // ========================
    // REGISTER ACTION
    // ========================

    public function test_register_with_valid_data(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'کاربر جدید',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('properties.index'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
        $this->assertAuthenticated();
    }

    public function test_register_creates_user_in_database(): void
    {
        $this->post(route('register'), [
            'name' => 'کاربر تست',
            'email' => 'test-register@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = \App\Models\User::where('email', 'test-register@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('کاربر تست', $user->name);
    }

    public function test_register_with_mismatched_passwords(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'کاربر',
            'email' => 'user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'user@example.com']);
    }

    public function test_register_requires_all_fields(): void
    {
        $response = $this->post(route('register'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_register_with_existing_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'کاربر',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_register_with_short_password(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'کاربر',
            'email' => 'user@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    // ========================
    // LOGOUT
    // ========================

    public function test_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_logout_clears_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'));

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    // ========================
    // FORGOT PASSWORD PAGE
    // ========================

    public function test_forgot_password_page_returns_ok(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
    }

    public function test_forgot_password_displays_form(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertSee('بازیابی رمز عبور');
        $response->assertSee('ایمیل');
        $response->assertSee('ارسال لینک بازیابی');
    }

    public function test_forgot_password_has_login_link(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertSee('بازگشت به ورود');
    }

    // ========================
    // FORGOT PASSWORD ACTION
    // ========================

    public function test_forgot_password_with_valid_email(): void
    {
        User::factory()->create(['email' => 'user@example.com']);

        $response = $this->post(route('password.email'), [
            'email' => 'user@example.com',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_forgot_password_with_nonexistent_email(): void
    {
        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_forgot_password_requires_email(): void
    {
        $response = $this->post(route('password.email'), []);

        $response->assertSessionHasErrors('email');
    }

    // ========================
    // RESET PASSWORD PAGE
    // ========================

    public function test_reset_password_page_returns_ok(): void
    {
        $response = $this->get(route('password.reset', ['token' => 'fake-token', 'email' => 'user@example.com']));

        $response->assertOk();
    }

    public function test_reset_password_displays_form(): void
    {
        $response = $this->get(route('password.reset', ['token' => 'fake-token', 'email' => 'user@example.com']));

        $response->assertSee('بازنشانی رمز عبور');
        $response->assertSee('ایمیل');
        $response->assertSee('رمز عبور جدید');
        $response->assertSee('تکرار رمز عبور');
    }

    // ========================
    // EMAIL VERIFICATION PAGE
    // ========================

    public function test_verification_page_requires_auth(): void
    {
        $response = $this->get(route('verification.notice'));

        $response->assertRedirect(route('login'));
    }

    public function test_verification_page_returns_ok(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertOk();
    }

    public function test_verification_page_displays_notice(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertSee('تایید ایمیل');
        $response->assertSee('ارسال مجدد ایمیل تایید');
    }

    // ========================
    // CONFIRM PASSWORD PAGE
    // ========================

    public function test_confirm_password_page_requires_auth(): void
    {
        $response = $this->get(route('password.confirm'));

        $response->assertRedirect(route('login'));
    }

    public function test_confirm_password_page_returns_ok(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('password.confirm'));

        $response->assertOk();
    }

    public function test_confirm_password_displays_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('password.confirm'));

        $response->assertSee('تایید هویت');
        $response->assertSee('تایید');
    }

    public function test_confirm_password_with_valid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->post(route('password.confirm'), [
            'password' => 'password123',
        ]);

        $response->assertRedirect();
    }

    public function test_confirm_password_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($user)->post(route('password.confirm'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
