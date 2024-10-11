<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface VaccinationRepositoryInterface extends Repository
{
    /**
     * Get vaccination by scheduled date
     *
     * @param string $date
     * @return Collection
     */
    public function getVaccinationByScheduledDate(string $date): Collection;
}
