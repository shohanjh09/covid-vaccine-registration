<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\ScheduleVaccinationJob;

class VaccinationScheduling extends Command
{
    // The name and signature of the console command
    protected $signature = 'vaccination:schedule';

    // The console command description
    protected $description = 'Dispatch the ScheduleVaccinationJob for all users who haven’t been scheduled yet';

    // Execute the console command
    public function handle()
    {
        // Get all users who haven't been scheduled for vaccination
        $unscheduledUsers = User::doesntHave('vaccination')->get();

        foreach ($unscheduledUsers as $user) {
            // Dispatch the ScheduleVaccinationJob for each unscheduled user
            dispatch(new ScheduleVaccinationJob($user->id));
        }

        $this->info('Vaccination scheduling jobs have been dispatched successfully.');
    }
}
