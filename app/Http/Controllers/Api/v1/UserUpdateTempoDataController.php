<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\User\UserTempoDataRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserUpdateTempoDataController
 * @package App\Http\Controllers\Api\v1
 */
class UserUpdateTempoDataController extends Controller
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
     * @param Request $request
     * @param $token
     * @return JsonResponse
     */
    public function __invoke(Request $request, $token): JsonResponse
    {
        $this->responseData->initData();

        try {
            $this->userTempoDataRepository->updateTempoData($token, $request->all());

            $this->responseData->addSuccess('User tempo data updated');
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError('User cannot be found');
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
