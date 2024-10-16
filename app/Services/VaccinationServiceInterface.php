<?php

namespace App\Services;

interface VaccinationServiceInterface
{
    /**
     * Get the vaccination status of a user based on their NID.
     *
     * @param int $nid
     * @return array
     */
    public function getVaccinationStatus(int $nid): array;

    /**
     * Set a vaccination date for a user
     * @param int $userId
     * @return void
     */
    public function setVaccinationScheduleForUser(int $userId) : void;
}
