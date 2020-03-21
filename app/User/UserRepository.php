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
        return User::where('user_token', $token)->firstOrFail();
    }

    /**
     * @inheritDoc
     *
     * @todo: Add user validation
     */
    public function updateData(User $user, array $data)
    {
        $user->fill($data);
        $user->save();
    }
}
