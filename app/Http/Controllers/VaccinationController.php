<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUserRequest;
use App\Services\VaccinationServiceInterface;
use Illuminate\View\View;

class VaccinationController extends Controller
{
    protected VaccinationServiceInterface $vaccinationService;

    /**
     * Inject the VaccinationStatusService.
     */
    public function __construct(VaccinationServiceInterface $vaccinationService)
    {
        $this->vaccinationService = $vaccinationService;
    }

    /**
     * Show the search form.
     */
    public function showSearchForm() : View
    {
        return view('search.status');
    }

    /**
     * Search for vaccination status by NID.
     */
    public function searchStatus(SearchUserRequest $request)
    {
        $validatedData = $request->validated();

        $statusData = $this->vaccinationService->getVaccinationStatus((int) $validatedData['nid']);

        return view('search.status', $statusData);
    }
}
