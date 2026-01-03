<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchLocationService;
use Illuminate\Support\Facades\Log;

class FetchTruckLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repairs:fetchlocations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest truck positions and update repair locations';

    public function handle(FetchLocationService $service): void
    {

        try {
            
            Log::info('repairs:fetchlocations STARTED at ' . now());
            $result = $service->fetchAndUpdate();
            $this->info("Processed {$result['processed']} positions, updated {$result['updated']} repair(s).");
            Log::info('repairs:fetchlocations FINISHED at ' . now());

        } catch (\Throwable $e) {

            Log::error('Truck status Error' . $e->getMessage());
        }
    }
}
