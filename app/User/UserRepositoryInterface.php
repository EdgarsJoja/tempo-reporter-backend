<?php

namespace App\User;

use App\User;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface
{
    /**
     * @param string $token
     * @return User
     */
    public function getByToken(string $token): User;
}

