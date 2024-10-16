<?php

namespace App\Repositories;

use App\Models\ModelInterface;

interface VaccinationCenterCapacityRepositoryInterface extends Repository
{
    /**
     * Get vaccine center capacity by vaccine center id and date
     *
     * @param int $vaccineCenterId
     * @param string $date
     * @return ModelInterface|null
     */
    public function decrementRemainingCapacity(int $vaccineCenterId, string $date): ?ModelInterface;

    /**
     * Get vaccine center capacity by vaccine center id and date
     *
     * @param int $vaccineCenterId
     * @param string $date
     * @return ModelInterface|null
     */
    public function getCapacityRecordByVaccineCenterIdAndDate(int $vaccineCenterId, string $date): ?ModelInterface;
}
