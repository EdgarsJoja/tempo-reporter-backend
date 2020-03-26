<?php

namespace App\Console\Commands;

use App\Tempo\Worklog\WorklogServiceInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * ReportGenerateCommand constructor.
     * @param UserRepositoryInterface $userRepository
     * @param WorklogServiceInterface $worklogService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        WorklogServiceInterface $worklogService
    ) {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->worklogService = $worklogService;
    }

    /**
     *
     */
    public function handle(): void
    {
        try {
            $user = $this->userRepository->getByEmail($this->argument('email'));

            if ($user->tempoData) {
                var_dump($this->worklogService->getWorklog($user));
            } else {
                $this->warn('Cannot execute request due to missing user tempo API data');
            }
        } catch (ModelNotFoundException $e) {
            $this->error($e->getMessage());
        }
    }
}
