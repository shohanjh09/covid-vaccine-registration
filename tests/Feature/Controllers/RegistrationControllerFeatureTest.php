<?php

namespace Tests\Feature\Controllers;

use App\Models\VaccinationCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanSeeRegistrationForm()
    {
        VaccinationCenter::factory()->count(3)->create(['active' => true]);

        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('registration.register');
        $response->assertViewHas('vaccineCenters');
    }

    public function testUserCanRegisterForVaccination()
    {
        $vaccineCenter = VaccinationCenter::factory()->create();

        $response = $this->post(route('register.submit'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'nid' => '123456789',
            'vaccination_center_id' => $vaccineCenter->id,
        ]);

        $response->assertRedirect(route('search'));
        $response->assertSessionHas('success', 'You have successfully registered for vaccination. The vaccination date will be assigned soon.');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'nid' => '123456789',
        ]);
    }
}
