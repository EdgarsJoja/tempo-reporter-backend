<?php

namespace App\User;

use App\Registry\CurrentUserInterface;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UserRepository
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var CurrentUserInterface
     */
    protected $currentUser;

    /**
     * UserRepository constructor.
     * @param CurrentUserInterface $currentUser
     */
    public function __construct(CurrentUserInterface $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @inheritDoc
     */
    public function getByToken(string $token): User
    {
        if (!$this->currentUser->get()) {
            try {
                $this->currentUser->set(User::where('user_token', $token)->firstOrFail());
            } catch (Exception $e) {
                throw new ModelNotFoundException('User cannot be found');
            }
        }

        return $this->currentUser->get();
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
     * @todo: Add current user caching
     */
    public function getByEmail(string $email): User
    {
        try {
            return User::where('email', $email)->firstOrFail();
        } catch (Exception $e) {
            throw new ModelNotFoundException(sprintf('User with email "%s" cannot be found', $email));
        }
    }

    /**
     * Get multiple users by given emails
     *
     * @param array $emails
     * @return Collection
     * @throws Exception
     */
    public function getMultipleByEmails(array $emails): Collection
    {
        try {
            return User::whereIn('email', $emails)->get();
        } catch (Exception $e) {
            throw $e;
            // @todo: Handle exception
        }

    }
}
