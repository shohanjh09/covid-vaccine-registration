<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends Repository
{

    /**
     * Get user by NID
     *
     * @param int $nid
     * @return mixed
     */
    public function getUserByNid(int $nid): mixed;

    /**
     * Get all users who haven't been scheduled for vaccination
     *
     * @return Collection
     */
    public function getUnscheduledUsers(): Collection;
}
