<?php

namespace App\User;

use App\UserReport;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;

/**
 * Class UserReportsRepository
 * @package App\User
 */
class UserReportsRepository implements UserReportsRepositoryInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserReportsRepository constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     * @todo: Move user outside of method, to allow passing already obtained users
     */
    public function saveReport(string $userToken, CarbonInterface $date, array $report)
    {
        $user = $this->userRepository->getByToken($userToken);

        $user->reports()->updateOrCreate(
            ['report_date' => $date->format('Y-m-d')],
            ['report_date' => $date, 'report' => json_encode($report)]
        );
    }

    /**
     * @inheritDoc
     * @todo: Move user outside of method, to allow passing already obtained users
     */
    public function getReport(string $userToken, CarbonInterface $date): UserReport
    {
        $user = $this->userRepository->getByToken($userToken);

        /** @var UserReport $report */
        $report = $user->reports()->whereDate('report_date', '=', $date)->firstOrFail();

        return $report;
    }
}
