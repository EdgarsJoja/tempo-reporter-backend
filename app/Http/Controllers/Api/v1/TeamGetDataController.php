<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Team;
use App\Team\TeamRepositoryInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TeamGetDataController
 * @package App\Http\Controllers\Api\v1
 */
class TeamGetDataController extends Controller
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
            // @todo: Add functionality which checks if user is in team, only then allow to get data
            $team = $this->teamRepository->getById($teamId);

            $this->responseData->addData('team', $this->prepareTeamData($team));
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError($e->getMessage());
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }

    /**
     * @param Team $team
     * @return array
     *
     * @todo: Consider moving this to separate class. Team data presentation class, for example.
     */
    protected function prepareTeamData(Team $team): array
    {
        $data = $team->toArray();
        $teamUsersEmails = $team->users()->pluck('email')->toArray();

        $data['emails'] = $teamUsersEmails;

        return $data;
    }
}
