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
     * @param string|null $date
     * @return array
     */
    public function getWorklog(User $user, string $date = null): array;
}
