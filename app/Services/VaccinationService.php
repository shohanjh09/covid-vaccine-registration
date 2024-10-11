<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationRepositoryInterface;
use App\Repositories\VaccinationCenterCapacityRepositoryInterface;
use App\Repositories\VaccinationCenterRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VaccinationService implements VaccinationServiceInterface
{
    /**
     * @var VaccinationCenterCapacityRepositoryInterface
     */
    protected VaccinationCenterCapacityRepositoryInterface $vaccineCenterCapacityRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var VaccinationRepositoryInterface
     */
    protected VaccinationRepositoryInterface $vaccinationRepository;

    /**
     * @var VaccinationCenterRepositoryInterface
     */
    protected VaccinationCenterRepositoryInterface $vaccineCenterRepository;

    public function __construct(
        UserRepositoryInterface                  $userRepository,
        VaccinationRepositoryInterface           $vaccinationRepository,
        VaccinationCenterRepositoryInterface     $vaccineCenterRepository,
        VaccinationCenterCapacityRepositoryInterface $vaccineCenterCapacityRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->vaccinationRepository = $vaccinationRepository;
        $this->vaccineCenterRepository = $vaccineCenterRepository;
        $this->vaccineCenterCapacityRepository = $vaccineCenterCapacityRepository;
    }

    /**
     * @inheritDoc
     */
    public function getVaccinationStatus(int $nid): array
    {
        $user = $this->userRepository->getUserByNid($nid);

        if (!$user) {
            return ['status' => 'Not scheduled'];
        }

        $vaccination = $user->vaccination;

        return match (true) {
            is_null($vaccination) => ['status' => 'Not scheduled'],
            $vaccination->scheduled_date > now() => [
                'status' => 'Scheduled',
                'scheduledDate' => $vaccination->scheduled_date,
            ],
            default => [
                'status' => 'Vaccinated',
                'vaccinatedDate' => $vaccination->scheduled_date,
            ],
        };
    }

    /**
     * @inheritDoc
     */
    public function setVaccinationScheduleForUser(int $userId): void
    {
        try {
            DB::transaction(function () use ($userId) {
                $user = $this->userRepository->get($userId);

                // Find the next available date
                $nextAvailableDate = $this->findNextAvailableDate($user->vaccination_center_id);

                $this->vaccinationRepository->create([
                    'user_id' => $user->id,
                    'scheduled_date' => $nextAvailableDate,
                ]);

                // Reduce the capacity for that day
                $this->vaccineCenterCapacityRepository->decrementRemainingCapacity($user->vaccination_center_id, $nextAvailableDate);
            });
        } catch (\Exception $e) {
            // Log or handle the error
            Log::error('Vaccination scheduling failed: ' . $e->getMessage());
        }
    }


    /**
     * Find the next available date for vaccination at the selected center.
     *
     * @param int $vaccineCenterId
     * @return string  The next available vaccination date.
     */
    private function findNextAvailableDate(int $vaccineCenterId): string
    {
        // Start from today's date
        $date = Carbon::now();

        while (true) {
            // Check if the current day is between Sunday (0) and Thursday (4)
            if ($date->dayOfWeek >= 0 && $date->dayOfWeek <= 4) {
                // Check if the current date has available capacity
                $capacityRecord = $this->vaccineCenterCapacityRepository->getCapacityRecordByVaccineCenterIdAndDate($vaccineCenterId, $date->toDateString());

                // If no record exists, create one with the center's daily capacity
                if (!$capacityRecord) {
                    $center = $this->vaccineCenterRepository->get($vaccineCenterId);

                    $capacityRecord = $this->vaccineCenterCapacityRepository->create([
                        'vaccination_center_id' => $vaccineCenterId,
                        'date' => $date->toDateString(),
                        'remaining_capacity' => $center->daily_capacity
                    ]);
                }

                // If there is remaining capacity, return this date
                if ($capacityRecord->remaining_capacity > 0) {
                    return $date->toDateString();
                }
            }

            // Move to the next day if fully booked or it's a weekend (Friday/Saturday)
            $date->addDay();
        }
    }
}
