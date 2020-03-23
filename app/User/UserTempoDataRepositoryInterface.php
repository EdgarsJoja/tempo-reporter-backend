<?php

namespace App\User;

use App\TempoData;

/**
 * Interface UserTempoDataRepositoryInterface
 * @package App\User
 */
interface UserTempoDataRepositoryInterface
{
    /**
     * @param string $userToken
     * @return TempoData
     */
    public function getTempoData(string $userToken): TempoData;

    /**
     * @param string $userToken
     * @param array $data
     * @return bool
     */
    public function updateTempoData(string $userToken, array $data): bool;
}
