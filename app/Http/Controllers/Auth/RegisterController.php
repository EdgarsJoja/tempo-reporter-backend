<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UserAlreadyExistsException;
use App\Http\Controllers\ApiControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Utils\ResponseDataInterface;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller implements ApiControllerInterface
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
     * Create a new controller instance.
     *
     * @param Request $request
     * @param JsonResponse $jsonResponse
     * @param ResponseDataInterface $responseData
     */
    public function __construct(Request $request, JsonResponse $jsonResponse, ResponseDataInterface $responseData)
    {
        $this->request = $request;
        $this->jsonResponse = $jsonResponse;
        $this->responseData = $responseData;
    }

    /**
     * Register new user
     */
    public function __invoke(): JsonResponse
    {
        $this->responseData->initData();

        try {
            $this->validateRequest();
            $this->processRequest();

            $this->responseData->addSuccess(__('Registration finished successfully'));
        } catch (ValidationException $e) {
            $this->responseData->addError(__('Invalid input data'));

            Log::alert($e->getMessage());
        } catch (UserAlreadyExistsException $e) {
            $this->responseData->addError($e->getMessage());
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
     * @throws UserAlreadyExistsException
     */
    protected function processRequest(): void
    {
        $user = new User($this->request->post());

        if (User::where('email', '=', $user->email)->exists()) {
            throw new UserAlreadyExistsException('User with this email already exists');
        }

        $user->password = app('hash')->make($this->request->post('password'));

        $user->save();
    }
}
