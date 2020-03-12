<?php

namespace App\User;

/**
 * Interface ApiTokenGeneratorInterface
 * @package App\User
 */
interface ApiTokenGeneratorInterface
{
    /**
     * Generates API token string
     *
     * @return string
     */
    public function generate(): string;
}

