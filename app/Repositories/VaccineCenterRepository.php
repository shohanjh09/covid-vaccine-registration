<?php

namespace App\Repositories;

use App\Exceptions\NotImplementedException;
use App\Models\ModelInterface;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Collection;

class VaccineCenterRepository implements VaccineCenterRepositoryInterface
{
    /**
     * @var VaccineCenter
     */
    protected $model;

    public function __construct(VaccineCenter $model) {
        $this->model = $model;
    }

    public function create(array $data): ?ModelInterface
    {
        return $this->model->firstOrCreate($data);
    }

    public function delete(int $id): bool {
        throw new NotImplementedException;
    }

    public function get(int $id, bool $withTrashed = false): ?ModelInterface{
        throw new NotImplementedException;
    }

    public function getAll(int $offset = 0, int $limit = null, bool $withTrashed = false): Collection {
        throw new NotImplementedException;
    }

    public function update(int $id, array $data): ?ModelInterface {
        throw new NotImplementedException;
    }



    public function getActiveVaccineCenters() : Collection
    {
        return $this->model
            ->where('active', true)
            ->orderBy('name', 'asc')
            ->get();
    }

}
