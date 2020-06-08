<?php

namespace App\User;

use App\User;

/**
 * Class UserDataPresentation
 * @package App\User
 */
class UserDataPresentation implements UserDataPresentationInterface
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Wrap user model with presentation layer logic
     *
     * @param User $user
     * @return $this
     */
    public function wrap(User $user): UserDataPresentationInterface
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user title from available data
     *
     * @return string
     */
    public function getTitle(): string
    {
        $title = $this->user->email;

        if ($this->user->first_name) {
            if ($this->user->last_name) {
                $title = sprintf('%s %s (%s)', $this->user->first_name, $this->user->last_name, $title);
            } else {
                $title = sprintf('%s (%s)', $this->user->first_name, $title);
            }
        }

        return $title;
    }
}
