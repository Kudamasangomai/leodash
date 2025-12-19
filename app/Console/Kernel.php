<?php

namespace App\Console;

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
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')->everyMinute();


             $schedule->command('repairs:fetchlocations')
            ->timezone('Africa/Harare')
            ->hourly()
            ->runInBackground()  // Optional: prevents blocking other tasks
            ->onSuccess(function () {
                Log::info('repairs:fetchlocations ran successfully at ' . now());
            });

    }
}
