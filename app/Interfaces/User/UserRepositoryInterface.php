<?php

namespace App\Interfaces\User;
use App\Models\User;

interface UserRepositoryInterface {

    public function createUser(array $data);
}
