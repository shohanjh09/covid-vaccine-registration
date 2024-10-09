<?php

namespace App\Http\Controllers;

use App\Jobs\ScheduleVaccinationJob;
use App\Models\User;
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
        //TODO:// get all the active vaccine center
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

        // Redirect to the search page with a success message
        return redirect()->route('search')->with('success', 'You have successfully registered for vaccination. The vaccination date will be assigned soon.');
    }
}
