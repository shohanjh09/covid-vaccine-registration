<?php

namespace App\Console\Commands;

use App\Models\Vaccination;
use App\Notifications\VaccinationReminder;
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
    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString();
        $vaccinations = Vaccination::where('scheduled_date', $tomorrow)->get();

        foreach ($vaccinations as $vaccination) {
            $user = $vaccination->user;

            // Send for notification
            $user->notify(new VaccinationReminder($vaccination));
        }
    }
}
