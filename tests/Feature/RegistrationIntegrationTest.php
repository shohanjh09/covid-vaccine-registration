<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccinationCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register_and_be_scheduled_for_vaccination()
    {
        // Create a vaccine center with capacity
        $vaccineCenter = VaccinationCenter::factory()->create(['daily_capacity' => 100]);

        // Register a user
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'nid' => '1234567890',
            'vaccination_center_id' => $vaccineCenter->id,
        ]);

        $response->assertRedirect('/search?nid=1234567890');

        // Check that the user was created
        $this->assertDatabaseHas('users', ['nid' => '1234567890']);

        // Schedule the vaccination
        $this->artisan('schedule:vaccinations');

        // Check that the user was assigned a scheduled date
        $this->assertDatabaseHas('vaccinations', [
            'user_id' => User::where('nid', '1234567890')->first()->id,
            'vaccination_center_id' => $vaccineCenter->id,
            'scheduled_date' => now()->addDays(1)->toDateString(),
        ]);
    }
}
