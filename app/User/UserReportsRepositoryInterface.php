<?php

namespace App\User;

use App\UserReport;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;

/**
 * Interface UserReportsRepositoryInterface
 * @package App\User
 */
interface UserReportsRepositoryInterface
{
    /**
     * @param string $userToken
     * @param CarbonInterface $date
     * @param array $report
     * @return mixed
     */
    public function saveReport(string $userToken, CarbonInterface $date, array $report);

    /**
     * @param string $userToken
     * @param CarbonInterface $date
     * @return UserReport
     */
    public function getReport(string $userToken, CarbonInterface $date): UserReport;
}
