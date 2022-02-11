<?php

namespace App\Repositories\User;

use App\Exceptions\User\CreateUserErrorException;
use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\QueryException;

class UserRepository implements UserRepositoryInterface{
    /**
     * @param array $data

     * @throws CreateUserErrorException
     */
    public function createUser(array $data)
    {
        try {
            return User::upsert($data, 'email');
        } catch (QueryException $e) {
            throw new CreateUserErrorException($e);
        }
    }
}
