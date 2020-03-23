<?php

namespace App\Providers;

use App\Http\Utils\ResponseData;
use App\Http\Utils\ResponseDataInterface;
use App\Http\Utils\UserValidation;
use App\Http\Utils\UserValidationInterface;
use App\User\ApiTokenGenerator;
use App\User\ApiTokenGeneratorInterface;
use App\User\UserTempoDataRepository;
use App\User\UserTempoDataRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\User\UserRepository;
use App\User\UserRepositoryInterface;

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

        // User
        $this->app->bind(ApiTokenGeneratorInterface::class, ApiTokenGenerator::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserTempoDataRepositoryInterface::class, UserTempoDataRepository::class);
    }
}