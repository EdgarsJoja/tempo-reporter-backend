<?php

namespace App\Tempo\Worklog;

use App\User;

/**
 * Interface WorklogServiceInterface
 * @package App\Tempo\Worklog
 */
interface WorklogServiceInterface
{
    /**
     * @param User $user
     * @return array
     */
    public function getWorklog(User $user): array;
}
