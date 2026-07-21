<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyFlashMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_store_flash_message(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title' => 'Test Property Flash Message',
            'price' => 10000000,
            'listing_type' => 'sale',
        ]);

        $response->assertSessionHas('success');
    }

    public function test_failed_store_flash_message(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($user)->post(route('properties.store'), []);

        $response->assertSessionHasErrors();
        $response->assertSessionMissing('success');
    }
}
