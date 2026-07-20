<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect();
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get(route('dashboard'))->assertForbidden();
    }

    public function test_admin_can_access_dashboard(): void
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_dashboard_displays_stats(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        Property::factory()->count(3)->create();

        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertSee('کل املاک')
            ->assertSee('3');
    }

    public function test_dashboard_displays_welcome_message(): void
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertSee('خوش آمدید');
    }

    public function test_dashboard_displays_admin_layout_sidebar(): void
    {
        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertSee('پنل مدیریت')
            ->assertSee('داشبورد');
    }

    public function test_admin_redirect_works(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('dashboard'));
    }

    public function test_dashboard_displays_recent_properties(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        Property::factory()->create(['title' => 'Recent Property']);

        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertSee('Recent Property')
            ->assertSee('آخرین املاک');
    }

    public function test_dashboard_displays_recent_inquiries(): void
    {
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $property = Property::factory()->create();

        PropertyInquiry::create([
            'property_id' => $property->id,
            'customer_name' => 'Inquiry User',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->get(route('dashboard'))
            ->assertSee('Inquiry User')
            ->assertSee('آخرین درخواست‌ها');
    }
}
