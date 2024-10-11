<?php

namespace App\Console\Commands;

use App\Notifications\VaccinationReminder;
use App\Repositories\VaccinationRepositoryInterface;
use Illuminate\Console\Command;

class VaccinationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccination:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vaccination reminder notifications to users scheduled for vaccination tomorrow';

    /**
     * Execute the console command.
     */
    public function handle(VaccinationRepositoryInterface $vaccinationRepository): void
    {
        $tomorrow = $this->getTomorrowDate();
        $vaccinations = $vaccinationRepository->getVaccinationByScheduledDate($tomorrow);

        foreach ($vaccinations as $vaccination) {
            $user = $vaccination->user;

            if ($user) {
                // Send for notification
                $user->notify(new VaccinationReminder($vaccination));
            }
        }
    }

    /**
     * Get tomorrow's date
     *
     * @return string
     */
    private function getTomorrowDate(): string
    {
        return now()->addDay()->toDateString();
    }
}
