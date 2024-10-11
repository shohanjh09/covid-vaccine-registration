<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\RegistrationController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationCenterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class RegistrationControllerUnitTest extends TestCase
{
    protected $userRepositoryMock;
    protected $vaccineCenterRepositoryMock;
    protected RegistrationController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->vaccineCenterRepositoryMock = Mockery::mock(VaccinationCenterRepositoryInterface::class);

        $this->controller = new RegistrationController($this->userRepositoryMock, $this->vaccineCenterRepositoryMock);
    }

    public function testShowRegistrationFormReturnsCorrectView()
    {
        // Create a mock Eloquent collection
        $vaccineCenters = new Collection([
            (object)['name' => 'Center1'],
            (object)['name' => 'Center2'],
        ]);

        $this->vaccineCenterRepositoryMock->shouldReceive('getActiveVaccineCenters')
            ->once()
            ->andReturn($vaccineCenters);

        $response = $this->controller->showRegistrationForm();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('registration.register', $response->name());
        $this->assertArrayHasKey('vaccineCenters', $response->getData());
        $this->assertEquals($vaccineCenters, $response->getData()['vaccineCenters']);
    }

    public function testRegisterCreatesUserAndRedirectsToSearch()
    {
        // Mock user data and User model
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com', 'nid' => '123456789'];

        // Mocking the request validation
        $request = Mockery::mock(CreateUserRequest::class);
        $request->shouldReceive('validated')->andReturn($userData);

        // Mock the User model
        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('getAttribute')->with('name')->andReturn('John Doe');
        $mockUser->shouldReceive('getAttribute')->with('email')->andReturn('john@example.com');
        $mockUser->shouldReceive('getAttribute')->with('nid')->andReturn('123456789');

        // Mock the repository to return the mock User model
        $this->userRepositoryMock->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn($mockUser);

        // Call the register method and assert the correct redirection
        $response = $this->controller->register($request);

        // Assert that the response is a redirect to the search route
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('search'), $response->getTargetUrl());
    }
}
