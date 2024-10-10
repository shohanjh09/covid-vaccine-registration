<?php

namespace App\Repositories;

interface UserRepositoryInterface extends Repository
{

    /**
     * Get user by NID
     *
     * @param int $nid
     * @return mixed
     */
    public function getUserByNid(int $nid): mixed;
}
