<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Models\Vaccination;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VaccinationServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testUserNotFoundInVaccinationStatus()
    {
        $response = $this->get('/search/status?nid=123456789');

        $response->assertStatus(200);
        $response->assertViewIs('search.status');
        $response->assertViewHas('status', 'Not registered');
    }

    public function testVaccinationStatusNotScheduled()
    {
        // Create a user but no vaccination record
        $user = User::factory()->create(['nid' => 123456789]);

        $response = $this->get('/search/status?nid=123456789');

        $response->assertStatus(200);
        $response->assertViewIs('search.status');
        $response->assertViewHas('status', 'Not scheduled');
    }

    public function testVaccinationStatusScheduled()
    {
        // Create a user with a future vaccination date
        $user = User::factory()->create(['nid' => 123456789]);
        $vaccination = Vaccination::factory()->create([
            'user_id' => $user->id,
            'scheduled_date' => Carbon::parse('next monday')->format('Y-m-d'),
        ]);

        $response = $this->get('/search/status?nid=123456789');

        $response->assertStatus(200);
        $response->assertViewIs('search.status');
        $response->assertViewHas([
            'status' => 'Scheduled',
            'scheduledDate' => $vaccination->scheduled_date,
        ]);
    }

    public function testVaccinationStatusVaccinated()
    {
        // Create a user with a past vaccination date
        $user = User::factory()->create(['nid' => 123456789]);
        $vaccination = Vaccination::factory()->create([
            'user_id' => $user->id,
            'scheduled_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
        ]);

        $response = $this->get('/search/status?nid=123456789');

        $response->assertStatus(200);
        $response->assertViewIs('search.status');
        $response->assertViewHas([
            'status' => 'Vaccinated',
            'vaccinatedDate' => $vaccination->scheduled_date,
        ]);
    }
}
