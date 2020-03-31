<?php

namespace App\Registry;

use App\User;

/**
 * Class CurrentUser
 * @package App\Registry
 */
class CurrentUser implements CurrentUserInterface
{
    /** @var User */
    private $user;

    /**
     * @inheritDoc
     */
    public function get(): ?User
    {
        return $this->user;
    }

    /**
     * @inheritDoc
     */
    public function set(User $user)
    {
        $this->user = $user;
    }
}
