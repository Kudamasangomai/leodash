<?php

namespace App\Console;

use App\Jobs\SendPendingRepairsAlertJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\FetchTruckLocations::class,
        \App\Console\Commands\PendingRepairsJobCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')->everyMinute();


        $schedule->command('repairs:fetchlocations')
            ->timezone('Africa/Harare')
            ->hourly()
            ->runInBackground()
            ->onSuccess(function () {
                Log::info('repairs:fetchlocations ran successfully at ' . now());
            });

        $schedule->command('pending:repairs')
            ->dailyAt('9:00');
    }
}
