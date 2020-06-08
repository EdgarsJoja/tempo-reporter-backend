<?php

namespace App\Console;

use App\Console\Commands\ReportGenerateCommand;
use App\Console\Commands\TestCommand;
use App\Cron\TeamReportsGenerator;
use App\Cron\TeamReportsMailer;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ReportGenerateCommand::class,
        TestCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // @todo: Create commands and schedule them instead
        $schedule->call(new TeamReportsGenerator())->weekdays()->everyFiveMinutes();
        $schedule->call(new TeamReportsMailer())->weekdays()->everyMinute();
    }
}
