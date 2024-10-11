<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationCenterCapacityRepositoryInterface;
use App\Repositories\VaccinationCenterRepositoryInterface;
use App\Repositories\VaccinationRepositoryInterface;
use App\Services\VaccinationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class VaccinationServiceUnitTest extends TestCase
{
    protected $userRepositoryMock;
    protected $vaccinationRepositoryMock;
    protected $vaccineCenterRepositoryMock;
    protected $vaccineCenterCapacityRepositoryMock;
    protected $vaccinationService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock all repositories
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->vaccinationRepositoryMock = Mockery::mock(VaccinationRepositoryInterface::class);
        $this->vaccineCenterRepositoryMock = Mockery::mock(VaccinationCenterRepositoryInterface::class);
        $this->vaccineCenterCapacityRepositoryMock = Mockery::mock(VaccinationCenterCapacityRepositoryInterface::class);

        // Initialize VaccinationService with mocked repositories
        $this->vaccinationService = new VaccinationService(
            $this->userRepositoryMock,
            $this->vaccinationRepositoryMock,
            $this->vaccineCenterRepositoryMock,
            $this->vaccineCenterCapacityRepositoryMock
        );
    }

    public function testGetVaccinationStatusUserNotFound()
    {
        // Mock UserRepository to return null (Not registered)
        $this->userRepositoryMock->shouldReceive('getUserByNid')
            ->once()
            ->with(123456789)
            ->andReturn(null);

        // Call service method
        $result = $this->vaccinationService->getVaccinationStatus(123456789);

        // Assert the result
        $this->assertEquals(['status' => 'Not registered'], $result);
    }

    public function testGetVaccinationStatusNotScheduled()
    {
        // Mock a user without using setAttribute or setRelation
        $user = Mockery::mock(User::class)->makePartial();
        $user->vaccination = null;

        // Mock UserRepository to return the user
        $this->userRepositoryMock->shouldReceive('getUserByNid')
            ->once()
            ->with(123456789)
            ->andReturn($user);

        // Call service method
        $result = $this->vaccinationService->getVaccinationStatus(123456789);

        // Assert the result
        $this->assertEquals(['status' => 'Not scheduled'], $result);
    }

    public function testGetVaccinationStatusScheduled()
    {
        // Mock a user with a scheduled vaccination
        $user = Mockery::mock(User::class)->makePartial();
        $vaccination = (object) ['scheduled_date' => Carbon::now()->addDay()];
        $user->vaccination = $vaccination;

        // Mock UserRepository to return the user
        $this->userRepositoryMock->shouldReceive('getUserByNid')
            ->once()
            ->with(123456789)
            ->andReturn($user);

        // Call service method
        $result = $this->vaccinationService->getVaccinationStatus(123456789);

        // Assert the result
        $this->assertEquals([
            'status' => 'Scheduled',
            'scheduledDate' => $vaccination->scheduled_date,
        ], $result);
    }

    public function testGetVaccinationStatusVaccinated()
    {
        // Mock a user with a past vaccination
        $user = Mockery::mock(User::class)->makePartial();
        $vaccination = (object) ['scheduled_date' => Carbon::now()->subDay()];
        $user->vaccination = $vaccination;

        // Mock UserRepository to return the user
        $this->userRepositoryMock->shouldReceive('getUserByNid')
            ->once()
            ->with(123456789)
            ->andReturn($user);

        // Call service method
        $result = $this->vaccinationService->getVaccinationStatus(123456789);

        // Assert the result
        $this->assertEquals([
            'status' => 'Vaccinated',
            'vaccinatedDate' => $vaccination->scheduled_date,
        ], $result);
    }

    public function testSetVaccinationScheduleForUserHandlesException()
    {
        // Ensure exception handling works and errors are logged
        Log::shouldReceive('error')->once()->with(Mockery::type('string'));

        DB::shouldReceive('transaction')->once()->andThrow(new \Exception('Transaction error'));

        // Call the method and ensure it handles exceptions
        $this->vaccinationService->setVaccinationScheduleForUser(1);
    }
}
