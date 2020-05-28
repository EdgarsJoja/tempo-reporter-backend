<?php

namespace App\User;

use App\User;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): User;

    /**
     * Get multiple users by given emails
     *
     * @param array $emails
     * @return Collection
     */
    public function getMultipleByEmails(array $emails): Collection;

    /**
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function updateData(User $user, array $data);
}
