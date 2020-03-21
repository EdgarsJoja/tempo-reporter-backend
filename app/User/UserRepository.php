<?php

namespace App\User;

use App\User;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getByToken(string $token): User
    {
        $user = User::firstOrFail()->where('user_token', $token)->first();

        return $user ?? new User();
    }
}
