<?php

namespace App\Tempo\Worklog;

use App\Utils\TimeFormatterInterface;
use Carbon\CarbonInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Formatter
 * @package App\Tempo\Worklog
 */
class Formatter implements FormatterInterface
{
    /**
     * @var CarbonInterface
     */
    protected $dateManager;

    /**
     * @var TimeFormatterInterface
     */
    protected $timeFormatter;

    /**
     * Formatter constructor.
     * @param CarbonInterface $dateManager
     * @param TimeFormatterInterface $timeFormatter
     */
    public function __construct(CarbonInterface $dateManager, TimeFormatterInterface $timeFormatter)
    {
        $this->dateManager = $dateManager;
        $this->timeFormatter = $timeFormatter;
    }

    /**
     * @inheritDoc
     */
    public function format(ResponseInterface $response): array
    {
        $responseArray = json_decode($response->getBody(), true);

        $formattedWorklogs = [];
        $totalTime = 0;

        if (isset($responseArray['results']) && is_array($responseArray['results'])) {
            foreach ($responseArray['results'] as $worklog) {
                if (isset($worklog['issue']['key'])) {
                    $issueKey = $worklog['issue']['key'];

                    if (!isset($formattedWorklogs[$issueKey])) {
                        $formattedWorklogs[$issueKey]['time'] = 0;
                    }

                    $formattedWorklogs[$issueKey]['description'][] = $worklog['description'];

                    $timeSpent = (int)$worklog['timeSpentSeconds'];
                    $formattedWorklogs[$issueKey]['time'] += $timeSpent;
                    $totalTime += $timeSpent;
                }
            }
        }

        foreach ($formattedWorklogs as &$issue) {
            $issue['time'] = $this->timeFormatter->secondsToHumanTime($issue['time']);
        }

        unset($issue);

        return [
            'worklogs' => $formattedWorklogs,
            'total_time' => $this->timeFormatter->secondsToHumanTime($totalTime)
        ];
    }
}
