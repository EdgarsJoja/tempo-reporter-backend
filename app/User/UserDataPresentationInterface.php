<?php

namespace App\User;

use App\User;

/**
 * Interface UserDataPresentationInterface
 * @package App\User
 */
interface UserDataPresentationInterface
{
    /**
     * Wrap user model with presentation layer logic
     *
     * @param User $user
     * @return $this
     */
    public function wrap(User $user): self;

    /**
     * Get user title from available data
     *
     * @return string
     */
    public function getTitle(): string;
}
