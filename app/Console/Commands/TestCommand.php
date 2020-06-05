<?php

namespace App\Console\Commands;

use App\Mail\TeamReportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Class TestCommand
 * @package App\Console\Commands
 */
class TestCommand extends Command
{
    /**
     * Name
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Command for testing various functionality';

    /**
     *
     */
    public function handle(): void
    {
        Mail::to('test@test.com')
            ->send(new TeamReportMail());
    }
}
