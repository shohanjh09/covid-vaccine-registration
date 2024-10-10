<?php

namespace App\Repositories;

use App\Models\ModelInterface;
use Illuminate\Database\Eloquent\Collection;

interface Repository
{
    /**
     * Creates the record.
     *
     * @param array $data
     * @return ModelInterface|null
     */
    public function create(array $data): ?ModelInterface;

    /**
     * Updates the record.
     *
     * @param int $id
     * @param array $data
     * @return ModelInterface|null
     */
    public function update(int $id, array $data): ?ModelInterface;

    /**
     * Retrieves the record.
     *
     * @param int $id
     * @param bool $withTrashed
     * @return ModelInterface|null
     */
    public function get(int $id, bool $withTrashed = false): ?ModelInterface;

    /**
     * Deletes the record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

    /**
     * Gets all records by $params.
     *
     * @param int $offset
     * @param int|null $limit
     * @param bool $withTrashed
     * @return Collection
     */
    public function getAll(int $offset = 0, int $limit = null, bool $withTrashed = false): Collection;
}
