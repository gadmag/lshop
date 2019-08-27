<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (!$this->osProcessIsRunning('queue:work')) {

            $schedule->command('queue:work')->everyMinute();
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    /**
     * checks, if a process with $needle in the name is running
     *
     * @param string $needle
     * @return bool
     */
    protected function osProcessIsRunning($needle)
    {
        exec('ps aux -ww', $process_status);

        $result = array_filter($process_status,
            function ($var) use ($needle) {
                return strpos($var, $needle);
            });

        if (!empty($result)) {

            return true;
        }

        return false;
    }
}
