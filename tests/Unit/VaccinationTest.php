<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VaccinationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_vaccination_schedule_for_user()
    {
        $user = User::factory()->create();
        $vaccineCenter = VaccineCenter::factory()->create(['daily_capacity' => 100]);

        $vaccination = Vaccination::create([
            'user_id' => $user->id,
            'vaccine_center_id' => $vaccineCenter->id,
            'scheduled_date' => now()->addDays(1)->toDateString(),
        ]);

        $this->assertDatabaseHas('vaccinations', [
            'user_id' => $user->id,
            'vaccine_center_id' => $vaccineCenter->id,
            'scheduled_date' => $vaccination->scheduled_date,
        ]);
    }

    /** @test */
    public function it_checks_if_vaccine_center_has_capacity_left()
    {
        $vaccineCenter = VaccineCenter::factory()->create(['daily_capacity' => 100]);

        // Assume 90 people already registered
        Vaccination::factory()->count(90)->create(['vaccine_center_id' => $vaccineCenter->id]);

        // Check if the center can accept more registrations (should return true)
        $this->assertTrue($vaccineCenter->hasCapacity());

        // Register 10 more people, which fills the capacity
        Vaccination::factory()->count(10)->create(['vaccine_center_id' => $vaccineCenter->id]);

        // Now the center should be full
        $this->assertFalse($vaccineCenter->hasCapacity());
    }
}

