<?php

namespace App\Console\Commands;

use App\Jobs\ScheduleVaccinationJob;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Console\Command;

class VaccinationScheduling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccination:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the ScheduleVaccinationJob for all users who haven’t been scheduled yet';

    /**
     * Execute the console command.
     */
    public function handle(UserRepositoryInterface $userRepository) : void
    {
        // Get all users who haven't been scheduled for vaccination
        $unscheduledUsers = $userRepository->getUnscheduledUsers();

        foreach ($unscheduledUsers as $user) {
            // Dispatch the ScheduleVaccinationJob for each unscheduled user
            dispatch(new ScheduleVaccinationJob((int) $user->id));
        }

        $this->info('Vaccination scheduling jobs have been dispatched successfully.');
    }
}
