<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface VaccineCenterRepositoryInterface extends Repository
{
    /**
     * Get all active vaccine centers
     *
     * @return Collection
     */
    public function getActiveVaccineCenters() : Collection;
}
