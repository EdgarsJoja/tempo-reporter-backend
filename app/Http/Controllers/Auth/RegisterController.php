<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 *
 * @todo: Create API request interface and make all controllers implement it
 */
class RegisterController extends Controller
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
     * Create a new controller instance.
     *
     * @param Request $request
     * @param JsonResponse $jsonResponse
     */
    public function __construct(Request $request, JsonResponse $jsonResponse)
    {
        $this->request = $request;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * Register new user
     */
    public function execute(): JsonResponse
    {
        $responseData = $this->initResponse();

        try {
            $this->validateRequest();
        } catch (ValidationException $e) {
            $responseData['error'] = true;
            $responseData['message'] = __('Input data could not be validated.');

            Log::alert($e->getMessage());
        }

        $this->processRequest();

        $this->jsonResponse->setData($responseData);

        return $this->jsonResponse;
    }

    /**
     * @return array
     */
    protected function initResponse(): array
    {
        return [
            'error' => false,
            'message' => 'Registration successful.'
        ];
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
        $user = new User($this->request->post());
        $user->password = app('hash')->make($this->request->post('password'));

        $user->save();
    }
}
