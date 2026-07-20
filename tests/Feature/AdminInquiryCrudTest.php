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

class AdminInquiryCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        Location::factory()->create();
        PropertyType::factory()->create();
        PropertyStatus::factory()->create();
        $this->property = Property::factory()->create();
    }

    public function test_guest_cannot_access_inquiries(): void
    {
        $this->get(route('admin.inquiries.index'))->assertRedirect();
    }

    public function test_regular_user_cannot_access_inquiries(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->actingAs($user)->get(route('admin.inquiries.index'))->assertForbidden();
    }

    public function test_admin_can_list_inquiries(): void
    {
        PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Ali',
            'customer_phone' => '09121234567',
            'inquiry_type' => 'visit_request',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.inquiries.index'))
            ->assertOk()
            ->assertSee('Ali');
    }

    public function test_admin_can_filter_inquiries_by_status(): void
    {
        PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Pending',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);
        PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Closed',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '11:00:00',
            'status' => 'closed',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.inquiries.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('Pending')
            ->assertDontSee('Closed');
    }

    public function test_admin_can_view_inquiry(): void
    {
        $inquiry = PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'View Me',
            'customer_phone' => '09121234567',
            'message' => 'I want to visit',
            'inquiry_type' => 'visit_request',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.inquiries.show', $inquiry))
            ->assertOk()
            ->assertSee('View Me')
            ->assertSee('I want to visit');
    }

    public function test_admin_can_update_inquiry_status(): void
    {
        $inquiry = PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Status Test',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.inquiries.update-status', $inquiry), [
                'status' => 'contacted',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('property_inquiries', [
            'id' => $inquiry->id,
            'status' => 'contacted',
        ]);
    }

    public function test_admin_can_delete_inquiry(): void
    {
        $inquiry = PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Delete Me',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('admin.inquiries.destroy', $inquiry))
            ->assertRedirect();

        $this->assertDatabaseMissing('property_inquiries', ['id' => $inquiry->id]);
    }

    public function test_update_status_validates_status_value(): void
    {
        $inquiry = PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'Validation',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->patch(route('admin.inquiries.update-status', $inquiry), [
                'status' => 'invalid_status',
            ])
            ->assertSessionHasErrors(['status']);
    }

    public function test_inquiry_show_displays_property_info(): void
    {
        $inquiry = PropertyInquiry::create([
            'property_id' => $this->property->id,
            'customer_name' => 'With Property',
            'inquiry_type' => 'general',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '10:00:00',
            'status' => 'pending',
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.inquiries.show', $inquiry))
            ->assertSee($this->property->title);
    }
}
