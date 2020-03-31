<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\User;
use App\User\UserReportsRepositoryInterface;
use App\UserReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserGetReportController
 * @package App\Http\Controllers\Api\v1
 */
class UserGetReportController extends Controller
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
     * UserController constructor.
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserReportsRepositoryInterface $userReportsRepository
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserReportsRepositoryInterface $userReportsRepository
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userReportsRepository = $userReportsRepository;
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
            $report = $this->userReportsRepository->getReport($token, $dateObject);

            $this->responseData->addData('report', $report->report);
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
