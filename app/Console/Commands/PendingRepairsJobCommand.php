<?php

namespace App\Console\Commands;

use App\Jobs\SendPendingRepairsAlertJob;
use App\Services\SendPendingRepairsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
    public function handle( SendPendingRepairsService $service)
    {

        $service->send();
        Log::info('pending:repairs command executed successfully');
        return Command::SUCCESS;
    }
}
