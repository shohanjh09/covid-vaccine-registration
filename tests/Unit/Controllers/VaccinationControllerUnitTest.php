<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\VaccinationController;
use App\Http\Requests\SearchUserRequest;
use App\Services\VaccinationServiceInterface;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class VaccinationControllerUnitTest extends TestCase
{
    protected $vaccinationServiceMock;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the VaccinationServiceInterface
        $this->vaccinationServiceMock = Mockery::mock(VaccinationServiceInterface::class);

        // Create an instance of the controller with the mock
        $this->controller = new VaccinationController($this->vaccinationServiceMock);
    }

    public function testShowSearchFormReturnsCorrectView()
    {
        $response = $this->controller->showSearchForm();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('search.status', $response->name());
    }

    public function testSearchStatusReturnsCorrectView()
    {
        // Mock request data
        $request = Mockery::mock(SearchUserRequest::class);
        $request->shouldReceive('validated')
            ->once()
            ->andReturn(['nid' => '123456789']);

        // Mock service response
        $statusData = ['status' => 'Scheduled', 'scheduledDate' => '2024-10-15'];
        $this->vaccinationServiceMock->shouldReceive('getVaccinationStatus')
            ->once()
            ->with(123456789)
            ->andReturn($statusData);

        // Call the method
        $response = $this->controller->searchStatus($request);

        // Assert the response is a view and contains the correct data
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('search.status', $response->name());
        $this->assertEquals($statusData, $response->getData());
    }
}
