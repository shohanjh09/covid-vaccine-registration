<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface VaccineCenterRepositoryInterface extends Repository
{
    /**
     * Get all the active vaccine center
     * @return Collection
     */
    public function getActiveVaccineCenters() : Collection;
}
