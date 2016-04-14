<?php

namespace Modules\Core\Application\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Core\Console\ApiGenerateKeyCommand;
use Modules\Core\Console\DemoCommand;
use Modules\Core\Console\InstallCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ApiGenerateKeyCommand::class,
        InstallCommand::class,
        DemoCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('society:demo -r')->daily()->evenInMaintenanceMode();
    }
}
