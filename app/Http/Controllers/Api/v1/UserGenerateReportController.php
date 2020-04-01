<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Tempo\Worklog\WorklogServiceInterface;
use App\User;
use App\User\UserReportsRepositoryInterface;
use App\User\UserRepositoryInterface;
use App\UserReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserGenerateReportController
 * @package App\Http\Controllers\Api\v1
 */
class UserGenerateReportController extends Controller
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
     * @var UserReportsRepositoryInterface
     */
    protected $userReportsRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var WorklogServiceInterface
     */
    protected $worklogService;

    /**
     * UserController constructor.
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserReportsRepositoryInterface $userReportsRepository
     * @param UserRepositoryInterface $userRepository
     * @param WorklogServiceInterface $worklogService
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserReportsRepositoryInterface $userReportsRepository,
        UserRepositoryInterface $userRepository,
        WorklogServiceInterface $worklogService
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userReportsRepository = $userReportsRepository;
        $this->userRepository = $userRepository;
        $this->worklogService = $worklogService;
    }

    /**
     * @param Request $request
     * @param $token
     * @param $date
     * @return JsonResponse
     *
     * @todo: Add requests data validation
     */
    public function __invoke(Request $request, $token, $date): JsonResponse
    {
        $this->responseData->initData();

        $dateObject = Carbon::parse($date);

        try {
            $user = $this->userRepository->getByToken($token);

            $report = $this->worklogService->getWorklog($user, $date);
            $this->userReportsRepository->saveReport($token, $dateObject, $report);

            $this->responseData->addData('report', $report);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case User::class:
                    $this->responseData->addError('User cannot be found');
                    break;
                case UserReport::class:
                    $this->responseData->addInfoMessage('User report cannot be found');
                    break;
                default:
                    $this->responseData->addError('Something went wrong');
            }
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }
}
