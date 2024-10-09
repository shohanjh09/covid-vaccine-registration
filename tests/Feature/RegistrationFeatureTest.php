<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\VaccineCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_registration_page_can_be_accessed()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Register for Vaccination');
    }

    /** @test */
    public function a_user_can_register_for_vaccination()
    {
        $vaccineCenter = VaccineCenter::factory()->create();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'nid' => '1234567890',
            'vaccine_center_id' => $vaccineCenter->id,
        ]);

        $response->assertRedirect('/search?nid=1234567890');
        $this->assertDatabaseHas('users', ['nid' => '1234567890']);
    }
}
