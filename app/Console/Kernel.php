<?php

namespace App\Console;

use Exception;
use App\Console\Commands\SyncDomains;
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
        SyncDomains::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        try {
            $minutes = setting('app.scan.frequency', '15');

            $cron = sprintf('*/%s * * * *', $minutes);

            $schedule->command('scout:sync')
                ->cron($cron);
        } catch (Exception $ex) {
            // Migrations have not yet been ran.
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
