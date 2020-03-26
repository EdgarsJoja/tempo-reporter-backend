<?php

namespace App\User;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    /**
     * @inheritDoc
     * @todo: Add email validation
     */
    public function getByEmail(string $email): User
    {
        try {
            return User::where('email', $email)->firstOrFail();
        } catch (Exception $e) {
            throw new ModelNotFoundException(sprintf('User with email "%s" cannot be found', $email));
        }
    }
}
