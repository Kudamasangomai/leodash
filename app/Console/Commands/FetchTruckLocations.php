<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchLocationService;

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

    public function handle(FetchLocationService $service): int
    {
        $this->info('Fetching truck locations...');

        $result = $service->fetchAndUpdate();

        $this->info("Processed {$result['processed']} positions, updated {$result['updated']} repair(s).");

        return 0;
    }
}
