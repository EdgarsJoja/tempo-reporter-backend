<?php

namespace App\Tempo;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface TempoClientInterface
 * @package App\Tempo
 */
interface TempoClientInterface
{
    /**
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed
     */
    public function request(string $url, array $params = [], array $headers = []): ResponseInterface;
}
