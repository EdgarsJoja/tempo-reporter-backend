<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\Http\Utils\UserValidationInterface;
use App\User;
use App\User\ApiTokenGeneratorInterface;
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
     * @var ApiTokenGeneratorInterface
     */
    protected $tokenGenerator;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     * @param UserValidationInterface $userValidation
     * @param ApiTokenGeneratorInterface $tokenGenerator
     */
    public function __construct(
        Request $request,
        JsonResponse $jsonResponse,
        ResponseDataInterface $responseData,
        UserValidationInterface $userValidation,
        ApiTokenGeneratorInterface $tokenGenerator
    ) {
        $this->request = $request;
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
        $this->userValidation = $userValidation;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * Login user
     */
    public function __invoke(): JsonResponse
    {
        $this->responseData->initData();

        try {
            $this->validateRequest();
            $this->processRequest();

            $this->responseData->addSuccess(__('Login successful'));
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
            $this->handleApiToken($user);
        } else {
            $this->responseData->addError(__('Login failed'));
        }
    }

    /**
     * @param User $user
     */
    protected function handleApiToken(User $user)
    {
        $apiToken = null;

        if ($user->getApiToken()) {
            $apiToken = $user->getApiToken();
        } else {
            $apiToken = $this->tokenGenerator->generate();

            $user->setApiToken($apiToken);
            $user->save();
        }

        $this->responseData->addData('user_token', $apiToken);
    }
}
