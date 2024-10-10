<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Models\VaccineCenterCapacity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VaccinationService implements VaccinationServiceInterface
{
    /**
     * @inheritDoc
     */
    public function getVaccinationStatus(string $nid): array
    {
        // Find the user by NID
        $user = User::where('nid', $nid)->first();

        if (!$user) {
            return ['status' => 'Not registered'];
        }

        // Fetch the user's vaccination status
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
    public function setVaccinationScheduleForUser(int $userId) : void
    {
        try {
            DB::transaction(function () use ($userId) {
                $user = User::find($userId);

                // Find the next available date
                $nextAvailableDate = $this->findNextAvailableDate($user->vaccineCenterId);

                // Schedule the user's vaccination
                Vaccination::create([
                    'user_id' => $user->id,
                    'vaccine_center_id' => $user->vaccineCenterId,
                    'scheduled_date' => $nextAvailableDate,
                ]);

                // Reduce the capacity for that day
                $capacityRecord = VaccineCenterCapacity::where('vaccine_center_id', $user->vaccineCenterId)
                    ->whereDate('date', $nextAvailableDate)
                    ->first();

                if ($capacityRecord) {
                    $capacityRecord->decrement('remaining_capacity');
                }
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
        $date = Carbon::now(); // Start from today's date

        while (true) {
            // Check if the current day is between Sunday (0) and Thursday (4)
            if ($date->dayOfWeek >= 0 && $date->dayOfWeek <= 4) {
                // Check if the current date has available capacity
                $capacityRecord = VaccineCenterCapacity::where('vaccine_center_id', $vaccineCenterId)
                    ->whereDate('date', $date->toDateString())
                    ->first();

                // If no record exists, create one with the center's daily capacity
                if (!$capacityRecord) {
                    $center = VaccineCenter::find($vaccineCenterId);
                    $capacityRecord = VaccineCenterCapacity::create([
                        'vaccine_center_id' => $vaccineCenterId,
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
