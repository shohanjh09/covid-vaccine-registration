<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use App\Models\VaccineCenterCapacity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ScheduleVaccinationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $vaccineCenterId;

    /**
     * Create a new job instance.
     *
     * @param  int  $userId
     * @param  int  $vaccineCenterId
     * @return void
     */
    public function __construct($userId, $vaccineCenterId)
    {
        $this->userId = $userId;
        $this->vaccineCenterId = $vaccineCenterId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->userId);

        // Find the next available date
        $nextAvailableDate = $this->findNextAvailableDate($this->vaccineCenterId);

        // Schedule the user's vaccination
        Vaccination::create([
            'user_id' => $user->id,
            'vaccine_center_id' => $this->vaccineCenterId,
            'scheduled_date' => $nextAvailableDate,
        ]);

        // Reduce the capacity for that day
        $capacityRecord = VaccineCenterCapacity::where('vaccine_center_id', $this->vaccineCenterId)
            ->whereDate('date', $nextAvailableDate)
            ->first();

        if ($capacityRecord) {
            $capacityRecord->decrement('remaining_capacity');
        }
    }

    /**
     * Find the next available date for vaccination at the selected center.
     *
     * @param  int  $vaccineCenterId
     * @return string  The next available vaccination date.
     */
    private function findNextAvailableDate($vaccineCenterId)
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
