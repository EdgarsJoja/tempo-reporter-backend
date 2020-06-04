<?php

namespace App\Team;

use App\Team;
use App\Tempo\Worklog\WorklogServiceInterface;
use App\User;
use App\User\UserReportsRepositoryInterface;
use Illuminate\Support\Facades\Date;

/**
 * Class TeamReportsGenerator
 * @package App\Team
 */
class TeamReportsGenerator implements TeamReportsGeneratorInterface
{
    /**
     * @var WorklogServiceInterface
     */
    protected $worklogService;

    /**
     * @var UserReportsRepositoryInterface
     */
    protected $userReportsRepository;

    /**
     * TeamReportsGenerator constructor.
     * @param WorklogServiceInterface $worklogService
     * @param UserReportsRepositoryInterface $userReportsRepository
     */
    public function __construct(
        WorklogServiceInterface $worklogService,
        UserReportsRepositoryInterface $userReportsRepository
    ) {
        $this->worklogService = $worklogService;
        $this->userReportsRepository = $userReportsRepository;
    }

    /**
     * Generate reports for all team users
     *
     * @param Team $team
     */
    public function generate(Team $team): void
    {
        $users = $team->users()->get();
        $date = Date::now();

        /** @var User $user */
        foreach ($users as $user) {
            $report = $this->worklogService->getWorklog($user);
            $this->userReportsRepository->saveReport($user->user_token, $date, $report);
        }
    }
}
