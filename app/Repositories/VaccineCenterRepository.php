<?php

namespace App\Repositories;

use App\Models\ModelInterface;
use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Collection;

class VaccineCenterRepository implements VaccineCenterRepositoryInterface
{
    /**
     * @var VaccineCenter
     */
    protected VaccineCenter $model;

    public function __construct(VaccineCenter $model) {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?ModelInterface
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool {
        return $this->model->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function get(int $id, bool $withTrashed = false): ?ModelInterface{
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function getAll(int $offset = 0, int $limit = null, bool $withTrashed = false): Collection {
        return $this->model->offset($offset)->limit($limit)->get();
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): ?ModelInterface {
        $vaccineCenter = $this->model->find($id);
        $vaccineCenter->update($data);

        return $vaccineCenter;
    }

    /**
     * @inheritDoc
     */
    public function getActiveVaccineCenters() : Collection
    {
        return $this->model
            ->where('active', VaccineCenter::ACTIVE)
            ->orderBy('name', 'asc')
            ->get();
    }
}
