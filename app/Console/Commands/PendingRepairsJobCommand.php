<?php

namespace App\Console\Commands;

use App\Jobs\SendPendingRepairsAlertJob;
use Illuminate\Console\Command;

class PendingRepairsJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pending:repairs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily pending repairs alert to technicians';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        SendPendingRepairsAlertJob::dispatch();
    }
}
