<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Show the form for registering a user for vaccination.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Retrieve all vaccine centers to display in the registration form
        $vaccineCenters = VaccineCenter::all();
        return view('registration.register', compact('vaccineCenters'));
    }

    /*public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'nid' => 'required|unique:users',
            'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        ]);

        $user = User::create($validatedData);

        return redirect()->route('search', ['nid' => $user->nid]);
    }*/

    /**
     * Handle the user registration for vaccination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nid' => 'required|unique:users,nid',
            'vaccine_center_id' => 'required|exists:vaccine_centers,id',
        ]);

        // Create a new user record
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nid' => $validatedData['nid'],
        ]);

        // Schedule the user's vaccination at the selected center
        Vaccination::create([
            'user_id' => $user->id,
            'vaccine_center_id' => $validatedData['vaccine_center_id'],
            'scheduled_date' => $this->findNextAvailableDate($validatedData['vaccine_center_id']),
        ]);

        // Redirect to the search page with a success message
        return redirect()->route('search')->with('success', 'You have successfully registered for vaccination.');
    }

    /**
     * Find the next available date for vaccination at the selected center.
     *
     * @param  int  $vaccineCenterId
     * @return string  The next available vaccination date.
     */
    private function findNextAvailableDate($vaccineCenterId)
    {
        $date = now();

        // Find the next available weekday (Sunday to Thursday) and ensure capacity is available
        while (true) {
            // Check if the current date is a weekday (Sunday to Thursday)
            if ($date->isWeekday() && $date->dayOfWeek < 5) {
                $vaccinationCount = Vaccination::where('vaccine_center_id', $vaccineCenterId)
                    ->whereDate('scheduled_date', $date->toDateString())
                    ->count();

                $centerCapacity = VaccineCenter::find($vaccineCenterId)->daily_capacity;

                if ($vaccinationCount < $centerCapacity) {
                    return $date->toDateString();
                }
            }

            // Move to the next day if the center is fully booked or it's a weekend
            $date->addDay();
        }
    }
}
