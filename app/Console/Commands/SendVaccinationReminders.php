<?php

namespace App\Console\Commands;

use App\Models\Vaccination;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendVaccinationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-vaccination-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString();
        $vaccinations = Vaccination::where('scheduled_date', $tomorrow)->get();

        foreach ($vaccinations as $vaccination) {
            // Send email
            Mail::to($vaccination->user->email)->send(new VaccinationReminder($vaccination));

            // If SMS is required, we would add:
            if ($vaccination->user->phone_number) {
                Notification::route('nexmo', $vaccination->user->phone_number)
                    ->notify(new VaccinationReminder($vaccination));
            }
        }
    }
}
