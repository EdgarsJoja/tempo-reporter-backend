<?php

namespace App\Tempo\Worklog;

use App\Tempo\Api\UserWorklog;
use App\User;

/**
 * Class WorklogService
 * @package App\Tempo\Worklog
 */
class WorklogService implements WorklogServiceInterface
{
    /**
     * @var UserWorklog
     */
    protected $userWorklog;

    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * WorklogService constructor.
     * @param UserWorklog $userWorklog
     * @param FormatterInterface $formatter
     */
    public function __construct(UserWorklog $userWorklog, FormatterInterface $formatter)
    {
        $this->userWorklog = $userWorklog;
        $this->formatter = $formatter;
    }

    /**
     * @inheritDoc
     */
    public function getWorklog(User $user, string $date = null): array
    {
        $worklogRequest = $this->userWorklog->setTempoData($user->tempoData);

        if ($date) {
            $worklogRequest->setDate($date);
        }

        return $this->formatter->format($worklogRequest->execute());
    }
}
