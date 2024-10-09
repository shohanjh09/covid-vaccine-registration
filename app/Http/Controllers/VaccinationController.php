<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VaccinationController extends Controller
{
    public function schedule()
    {
        // Fetch unvaccinated users and vaccine centers
        $users = User::whereDoesntHave('vaccination')->get();
        $vaccineCenters = VaccineCenter::all();

        foreach ($users as $user) {
            $center = $this->findAvailableCenter($vaccineCenters);
            if ($center) {
                $vaccinationDate = $this->findNextAvailableDate($center);

                Vaccination::create([
                    'user_id' => $user->id,
                    'vaccine_center_id' => $center->id,
                    'scheduled_date' => $vaccinationDate,
                ]);

                // Send email notification
                Mail::to($user->email)->send(new VaccinationScheduled($vaccinationDate));
            }
        }
    }

    public function search(Request $request)
    {
        $user = User::where('nid', $request->nid)->first();

        if (!$user) {
            return view('search', ['status' => 'Not registered']);
        }

        $vaccination = $user->vaccination;

        if (!$vaccination) {
            return view('search', ['status' => 'Not scheduled']);
        }

        if ($vaccination->scheduled_date > now()) {
            return view('search', ['status' => 'Scheduled', 'date' => $vaccination->scheduled_date]);
        }

        return view('search', ['status' => 'Vaccinated']);
    }


    private function findAvailableCenter($vaccineCenters)
    {
        foreach ($vaccineCenters as $center) {
            // Count the scheduled vaccinations for the center on the current day
            $vaccinationsToday = Vaccination::where('vaccine_center_id', $center->id)
                ->whereDate('scheduled_date', now()->toDateString())
                ->count();

            // Check if the center still has capacity for more vaccinations today
            if ($vaccinationsToday < $center->daily_capacity) {
                return $center;
            }
        }

        // If no center is available, return null
        return null;
    }

    private function findNextAvailableDate($center)
    {
        $date = now();

        while (true) {
            // Check if the current date is a weekday (Sunday to Thursday)
            if ($date->isWeekday() && $date->dayOfWeek < 5) {
                $vaccinationsOnDate = Vaccination::where('vaccine_center_id', $center->id)
                    ->whereDate('scheduled_date', $date->toDateString())
                    ->count();

                // If the center has not reached its capacity, return this date
                if ($vaccinationsOnDate < $center->daily_capacity) {
                    return $date->toDateString();
                }
            }

            // If the date is full or it's not a weekday, move to the next day
            $date->addDay();
        }
    }
}
