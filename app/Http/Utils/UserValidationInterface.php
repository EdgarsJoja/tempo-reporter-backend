<?php

namespace App\Http\Utils;

use App\User;

/**
 * Interface UserValidationInterface
 * @package App\Http\Utils
 */
interface UserValidationInterface
{
    /**
     * Validate user by credentials
     *
     * @param $credentials
     * @return User
     */
    public function validate($credentials): User;
}
