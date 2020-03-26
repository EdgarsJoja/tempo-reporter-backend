<?php

namespace App\Tempo;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TempoClient
 * @package App\Tempo
 */
class TempoClient implements TempoClientInterface
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * TempoClient constructor.
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @inheritDoc
     */
    public function request(string $url, array $params = [], array $headers = []): ResponseInterface
    {
        $result = null;

        try {
            $result =$this->httpClient->request(Request::METHOD_GET, $url, [
                'query' => $params,
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            // @todo: Add better handling
            Log::debug('Guzzle erorr: ' . $e->getMessage());
        }

        return $result;
    }
}
