<?php

namespace App\Console;

use App\Console\Commands\Install;
use App\Console\Commands\PolicyMakeCommand;
use App\Console\Commands\RequestMakeCommand;
use App\Console\Commands\ResourceMakeCommand;
use App\Console\Commands\SendTestEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Kernel
 * -----------------------
 * The console kernel to install console commands and to schedule commands
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Console
 */
class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [
        Install::class,
        SendTestEmail::class
    ];

    /**
     * Defines the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Registers the Closure based commands for the application.
     */
    protected function commands() {
        require base_path('routes/console.php');
    }
}
