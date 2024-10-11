<?php

namespace App\Repositories;

use App\Models\ModelInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected User $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?ModelInterface
    {
        return $this->model->firstOrCreate($data);
    }

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
        $user = $this->model->find($id);
        $user->update($data);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getUserByNid(int $nid): mixed
    {
        return $this->model->where('nid', $nid)->first();
    }

    /**
     * @inheritDoc
     */
    public function getUnscheduledUsers(): Collection
    {
        return $this->model->doesntHave('vaccination')->get();
    }
}
