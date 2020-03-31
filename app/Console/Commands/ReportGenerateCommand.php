<?php

namespace App\Console\Commands;

use App\Tempo\Worklog\WorklogServiceInterface;
use App\User\UserReportsRepositoryInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Date;

/**
 * Class ReportGenerateCommand
 * @package App\Console\Commands
 */
class ReportGenerateCommand extends Command
{
    /**
     * Name
     *
     * @var string
     */
    protected $signature = 'report:generate {email}';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Generate user report from Tempo API worklogs';

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var WorklogServiceInterface
     */
    protected $worklogService;

    /**
     * @var UserReportsRepositoryInterface
     */
    protected $userReportsRepository;

    /**
     * ReportGenerateCommand constructor.
     * @param UserRepositoryInterface $userRepository
     * @param WorklogServiceInterface $worklogService
     * @param UserReportsRepositoryInterface $userReportsRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        WorklogServiceInterface $worklogService,
        UserReportsRepositoryInterface $userReportsRepository
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->worklogService = $worklogService;
        $this->userReportsRepository = $userReportsRepository;
    }

    /**
     *
     */
    public function handle(): void
    {
        try {
            $user = $this->userRepository->getByEmail($this->argument('email'));

            if ($user->tempoData) {
                $date = Date::now();

                $report = $this->worklogService->getWorklog($user);
                $this->userReportsRepository->saveReport($user->user_token, $date, $report);

                $this->info('Report generated!');
            } else {
                $this->warn('Cannot execute request due to missing user tempo API data');
            }
        } catch (ModelNotFoundException $e) {
            $this->error($e->getMessage());
        }
    }
}
