<?php

namespace App\Providers;

use App\Http\Utils\ResponseData;
use App\Http\Utils\ResponseDataInterface;
use App\Http\Utils\UserValidation;
use App\Http\Utils\UserValidationInterface;
use App\Registry\CurrentUser;
use App\Registry\CurrentUserInterface;
use App\Team\TeamReportsGenerator;
use App\Team\TeamReportsGeneratorInterface;
use App\Team\TeamRepository;
use App\Team\TeamRepositoryInterface;
use App\Tempo\TempoClient;
use App\Tempo\TempoClientInterface;
use App\Tempo\Worklog\Formatter;
use App\Tempo\Worklog\FormatterInterface;
use App\Tempo\Worklog\WorklogService;
use App\Tempo\Worklog\WorklogServiceInterface;
use App\User\ApiTokenGenerator;
use App\User\ApiTokenGeneratorInterface;
use App\User\UserDataPresentation;
use App\User\UserDataPresentationInterface;
use App\User\UserReportsRepository;
use App\User\UserReportsRepositoryInterface;
use App\User\UserTempoDataRepository;
use App\User\UserTempoDataRepositoryInterface;
use App\Utils\TimeFormatter;
use App\Utils\TimeFormatterInterface;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
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
        $this->app->bind(ClientInterface::class, static function () {
            return new Client([
                'base_uri' => config('tempo.api_host')
            ]);
        });

        // Auth
        $this->app->bind(UserValidationInterface::class, UserValidation::class);

        // User
        $this->app->bind(ApiTokenGeneratorInterface::class, ApiTokenGenerator::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserTempoDataRepositoryInterface::class, UserTempoDataRepository::class);
        $this->app->bind(UserReportsRepositoryInterface::class, UserReportsRepository::class);
        $this->app->bind(UserDataPresentationInterface::class, UserDataPresentation::class);

        // Tempo
        $this->app->bind(TempoClientInterface::class, TempoClient::class);
        $this->app->bind(FormatterInterface::class, Formatter::class);
        $this->app->bind(WorklogServiceInterface::class, WorklogService::class);

        // Team
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(TeamReportsGeneratorInterface::class, TeamReportsGenerator::class);

        // Date & Time
        $this->app->bind(CarbonInterface::class, Carbon::class);
        $this->app->bind(TimeFormatterInterface::class, TimeFormatter::class);

        // Registry
        $this->app->singleton(CurrentUserInterface::class, CurrentUser::class);
    }
}
