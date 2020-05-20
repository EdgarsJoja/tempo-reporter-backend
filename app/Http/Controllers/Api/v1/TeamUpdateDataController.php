<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Team\TeamRepositoryInterface;
use App\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TeamUpdateDataController
 * @package App\Http\Controllers\Api\v1
 */
class TeamUpdateDataController extends Controller
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
     * TeamUpdateDataController constructor.
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
     * @return JsonResponse
     */
    public function __invoke(Request $request, $token): JsonResponse
    {
        $this->responseData->initData();

        try {
            $user = $this->userRepository->getByToken($token);

            $teamId = $request->get('team_id');

            if ($teamId) {
                $team = $this->teamRepository->getById($teamId);

                // Allow team updates only if current user is owner
                // @todo: Fix IDE not understanding Eloquent relationships
                if ($user->is($team->owner)) {
                    $this->teamRepository->updateData($team, $request->all());
                }
            } else {
                $this->teamRepository->createTeam($request->all(), $user);
            }

            $this->responseData->addSuccess('Team data updated');
        } catch (ModelNotFoundException $e) {
            $this->responseData->addError($e->getMessage());
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
