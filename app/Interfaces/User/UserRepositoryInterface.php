<?php

namespace App\Interfaces\User;
use App\Models\User;

interface UserRepositoryInterface {

    /**
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data);
}
