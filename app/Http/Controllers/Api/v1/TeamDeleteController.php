<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Team\TeamRepositoryInterface;
use App\User\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

/**
 * Class TeamDeleteController
 * @package App\Http\Controllers\Api\v1
 */
class TeamDeleteController extends Controller
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
     * @var TeamRepositoryInterface
     */
    protected $teamRepository;

    /**
     * TeamGetDataController constructor.
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserRepositoryInterface $userRepository
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserRepositoryInterface $userRepository,
        TeamRepositoryInterface $teamRepository
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userRepository = $userRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param Request $request
     * @param $token
     * @param $teamId
     * @return JsonResponse
     */
    public function __invoke(Request $request, $token, $teamId): JsonResponse
    {
        $this->responseData->initData();

        try {
            $user = $this->userRepository->getByToken($token);
            $team = $this->teamRepository->getById($teamId);

            if (!$user->is($team->owner)) {
                throw new UnauthorizedException('Current user is not allowed to edit this team');
            }

            $this->teamRepository->delete($teamId);

            $this->responseData->addSuccess('Team deleted successfully');
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError($e->getMessage());
        } catch (UnauthorizedException $e) {
            $this->responseData->addError($e->getMessage());
        } catch (Exception $e) {
            $this->responseData->addError('Team could not be deleted');
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
