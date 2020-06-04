<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    }
}
