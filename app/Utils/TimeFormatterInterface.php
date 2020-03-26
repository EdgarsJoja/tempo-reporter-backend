<?php

namespace App\Utils;

/**
 * Interface TimeFormatterInterface
 * @package App\Utils
 */
interface TimeFormatterInterface
{
    /**
     * Return human readable amount of time from given seconds
     *
     * @param int $seconds
     * @return string
     */
    public function secondsToHumanTime(int $seconds): string;
}
