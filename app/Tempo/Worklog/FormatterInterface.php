<?php

namespace App\Tempo\Worklog;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface FormatterInterface
 * @package App\Tempo\Worklog
 */
interface FormatterInterface
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function format(ResponseInterface $response): array;
}
