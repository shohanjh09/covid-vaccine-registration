<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_registered_user_can_see_their_vaccination_status()
    {
        $user = User::factory()->create(['nid' => '1234567890']);
        Vaccination::factory()->create(['user_id' => $user->id, 'scheduled_date' => now()->addDays(1)]);

        $response = $this->get('/search?nid=1234567890');
        $response->assertStatus(200);
        $response->assertSee('Scheduled');
    }

    /** @test */
    public function an_unregistered_user_sees_the_not_registered_status()
    {
        $response = $this->get('/search?nid=9999999999');
        $response->assertStatus(200);
        $response->assertSee('Not registered');
    }
}
