<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchUserRequest;
use App\Services\VaccinationServiceInterface;

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
    public function showSearchForm()
    {
        return view('search.search');
    }

    /**
     * Search for vaccination status by NID.
     */
    public function search(SearchUserRequest $request)
    {
        $request = $request->validated();

        $statusData = $this->vaccinationService->getVaccinationStatus((int) $request->nid);

        return view('search.status', $statusData);
    }
}
