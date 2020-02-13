<?php

namespace  App\Http\Utils;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserValidation
 * @package App\Http\Utils
 */
class UserValidation implements UserValidationInterface
{
    /**
     * @inheritDoc
     */
    public function validate($credentials): User
    {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        try {
            $user = User::where('email', $email)->firstOrFail();

            if (Hash::check($password, $user->password)) {
                return $user;
            }
        } catch (ModelNotFoundException $e) {
            // @todo: Add error messages
        }

        return new User();
    }
}
