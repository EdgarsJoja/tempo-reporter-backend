<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserUpdateDataController
 * @package App\Http\Controllers\Api\v1
 */
class UserUpdateDataController extends Controller
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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserRepositoryInterface $userRepository
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userRepository = $userRepository;
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
            $user = $this->userRepository->getByToken($token);

            $this->userRepository->updateData($user, $request->all());

            $this->responseData->addSuccess('User data updated');
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError('User cannot be found');
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
