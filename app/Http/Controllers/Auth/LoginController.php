<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Http\Utils\UserValidationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller implements ApiControllerInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var JsonResponse
     */
    protected $jsonResponse;

    /**
     * @var ResponseDataInterface
     */
    protected $responseData;

    /**
     * @var UserValidationInterface
     */
    protected $userValidation;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserValidationInterface $userValidation
     */
    public function __construct(
        Request $request,
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserValidationInterface $userValidation
    ) {
        $this->request = $request;
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userValidation = $userValidation;
    }

    /**
     * Login user
     */
    public function execute(): JsonResponse
    {
        $this->responseData->initData();

        try {
            $this->validateRequest();
            $this->processRequest();
        } catch (ValidationException $e) {
            $this->responseData->addError(__('Invalid login data.'));

            Log::alert($e->getMessage());
        }

        $this->jsonResponse->setData($this->responseData->getData());

        return $this->jsonResponse;
    }

    /**
     * @throws ValidationException
     */
    protected function validateRequest(): void
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required|between:6,255'
        ]);
    }

    /**
     * Process request
     */
    protected function processRequest(): void
    {
        $credentials = $this->request->only('email', 'password');

        $user = $this->userValidation->validate($credentials);

        if ($user->id) {
            $this->responseData->addSuccess('Success');
        } else {
            $this->responseData->addError('nope');
        }
    }
}
