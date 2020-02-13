<?php

namespace App\Providers;

use App\Http\Utils\ResponseData;
use App\Http\Utils\ResponseDataInterface;
use App\Http\Utils\UserValidation;
use App\Http\Utils\UserValidationInterface;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApiServiceProvider
 * @package App\Providers
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register binds
     */
    public function register(): void
    {
        // Http
        $this->app->bind(ResponseDataInterface::class, ResponseData::class);

        // Auth
        $this->app->bind(UserValidationInterface::class, UserValidation::class);
    }
}
