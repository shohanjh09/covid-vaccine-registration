<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\VaccineCenter;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccineCenterRepository;
use App\Repositories\VaccineCenterRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var VaccineCenterRepositoryInterface
     */
    protected VaccineCenterRepositoryInterface $vaccineCenterRepository;


    public function __construct(UserRepositoryInterface $userRepository,
                                VaccineCenterRepositoryInterface $vaccineCenterRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->vaccineCenterRepository = $vaccineCenterRepository;
    }

    /**
     * Show the form for registering a user for vaccination.
     *
     * @return View
     */
    public function showRegistrationForm(): View
    {
        // Retrieve all vaccine centers to display in the registration form
        //TODO:// get all the active vaccine center
        $vaccineCenters = VaccineCenter::all();
        $vaccineCenters = $this->vaccineCenterRepository->getAll()
        return view('registration.register', compact('vaccineCenters'));
    }

    /**
     * Handle the user registration for vaccination.
     *
     * @param CreateUserRequest $request
     * @return RedirectResponse
     */
    public function register(CreateUserRequest $request): RedirectResponse
    {
        $user = $this->userRepository->create($request->validated());

        // Redirect to the search page with a success message
        return redirect()->route('search')->with('success', 'You have successfully registered for vaccination. The vaccination date will be assigned soon.');
    }
}
