<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\User\UserTempoDataRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * Class UserGetTempoDataController
 * @package App\Http\Controllers\Api\v1
 */
class UserGetTempoDataController extends Controller
{
    /**
     * @var JsonResponse
     */
    protected $jsonResponse;

    /**
     * @var ResponseDataInterface
     */
    protected $responseData;

    /**
     * @var UserTempoDataRepositoryInterface
     */
    protected $userTempoDataRepository;

    /**
     * UserController constructor.
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserTempoDataRepositoryInterface $userTempoDataRepository
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserTempoDataRepositoryInterface $userTempoDataRepository
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userTempoDataRepository = $userTempoDataRepository;
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function __invoke($token): JsonResponse
    {
        $this->responseData->initData();

        try {
            $tempoData = $this->userTempoDataRepository->getTempoData($token);

            $this->responseData->addData('tempo_data', [
                'tempo_token' => $tempoData->tempo_token,
                'jira_account_id' => $tempoData->jira_account_id,
            ]);
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError('User cannot be found');
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
