<?php

namespace App\Utils;

use DateTime;

/**
 * Class TimeFormatter
 * @package App\Utils
 */
class TimeFormatter implements TimeFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function secondsToHumanTime(int $seconds): string
    {
        $dateFrom = new DateTime('@0');
        $dateTo = new DateTime("@$seconds");

        return $dateFrom->diff($dateTo)->format('%h hours, %i minutes');
    }
}
