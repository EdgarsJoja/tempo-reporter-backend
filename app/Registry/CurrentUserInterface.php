<?php

namespace App\Registry;

use App\User;

/**
 * Interface CurrentUserInterface
 * @package App\Registry
 */
interface CurrentUserInterface
{
    /**
     * @return User|null
     */
    public function get(): ?User;

    /**
     * @param User $user
     * @return mixed
     */
    public function set(User $user);
}
