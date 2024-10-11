<?php

namespace Tests\Feature\Controllers;

use App\Services\VaccinationServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class VaccinationControllerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanSeeSearchForm()
    {
        // Make a GET request to the search form route
        $response = $this->get(route('search'));

        // Assert the status is 200 and the correct view is displayed
        $response->assertStatus(200);
        $response->assertViewIs('search.status');
    }

    public function testUserCanSearchVaccinationStatus()
    {
        // Mock the VaccinationServiceInterface
        $vaccinationServiceMock = Mockery::mock(VaccinationServiceInterface::class);
        $this->app->instance(VaccinationServiceInterface::class, $vaccinationServiceMock);

        // Mock the service response
        $statusData = ['status' => 'Scheduled', 'scheduledDate' => '2024-10-15'];
        $vaccinationServiceMock->shouldReceive('getVaccinationStatus')
            ->once()
            ->with(123456789)
            ->andReturn($statusData);

        // Send a GET request with NID
        $response = $this->get(route('search.status', ['nid' => '123456789']));

        // Assert that the status is 200 and the correct view is returned
        $response->assertStatus(200);
        $response->assertViewIs('search.status');
        $response->assertViewHasAll($statusData);
    }
}
