<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccination;
use App\Models\VaccineCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus; // Facade for dispatching batch jobs
use App\Jobs\ScheduleVaccinationJob; // The job to handle scheduling

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

        // Dispatch the job to schedule the vaccination
        // It runs in the background and assigns the next available date
        dispatch(new ScheduleVaccinationJob($user->id, $validatedData['vaccine_center_id']));

        // Redirect to the search page with a success message
        return redirect()->route('search')->with('success', 'You have successfully registered for vaccination. The vaccination date will be assigned soon.');
    }
}
