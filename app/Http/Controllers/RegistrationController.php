<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VaccinationCenterRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var VaccinationCenterRepositoryInterface
     */
    protected VaccinationCenterRepositoryInterface $vaccineCenterRepository;


    public function __construct(UserRepositoryInterface $userRepository,
                                VaccinationCenterRepositoryInterface $vaccineCenterRepository
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
        $vaccineCenters = $this->vaccineCenterRepository->getActiveVaccineCenters();

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
