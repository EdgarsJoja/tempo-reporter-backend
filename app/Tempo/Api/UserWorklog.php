<?php

namespace App\Tempo\Api;

use App\Tempo\TempoClientInterface;
use App\TempoData;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserWorklog
 * @package App\Tempo\Api
 *
 * @todo: Add interface
 */
class UserWorklog
{
    protected const DATE_FORMAT = 'yy-m-d';

    /**
     * @var TempoClientInterface
     */
    protected $tempoClient;

    /**
     * @var DateTimeInterface
     */
    protected $dateManager;

    /** @var string */
    protected $date;

    /** @var TempoData */
    protected $tempoData;

    /**
     * UserWorklog constructor.
     * @param TempoClientInterface $tempoClient
     * @param CarbonInterface $dateManager
     */
    public function __construct(TempoClientInterface $tempoClient, CarbonInterface $dateManager)
    {
        $this->tempoClient = $tempoClient;
        $this->dateManager = $dateManager;

        $this->date = $this->dateManager->format(static::DATE_FORMAT);
    }

    /**
     * @param TempoData $tempoData
     * @return UserWorklog
     */
    public function setTempoData(TempoData $tempoData): self
    {
        $this->tempoData = $tempoData;

        return $this;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        return $this->tempoClient->request(
            implode([config('tempo.endpoints.user_worklogs'), $this->tempoData->jira_account_id]),
            [
                'from' => $this->date,
                'to' => $this->date,
            ],
            [
                'Authorization' => sprintf('Bearer %s', $this->tempoData->tempo_token)
            ]
        );
    }
}
