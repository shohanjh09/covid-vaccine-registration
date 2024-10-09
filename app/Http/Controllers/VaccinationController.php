<?php

namespace App\Http\Controllers;

use App\Services\VaccinationServiceInterface;
use Illuminate\Http\Request;

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
     * Search for vaccination status by NID.
     */
    public function search(Request $request)
    {
        // Validate the NID input
        $request->validate(['nid' => 'required']);

        // Get the vaccination status from the service
        $statusData = $this->vaccinationService->getVaccinationStatus($request->nid);

        // Return the appropriate view with the status
        return view('search.status', $statusData);
    }
}
