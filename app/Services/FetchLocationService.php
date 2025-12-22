<?php

namespace App\Services;

use App\Models\Truck;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchLocationService
{

    protected string $apiKey;
    protected string $baseurl;


    public function __construct()
    {
        $this->apiKey = config('services.globaltrack.key');
        $this->baseurl = config('services.globaltrack.api_url');
    }

    /**
     * Fetch XML positions and update repairs' location and reported_at for matching trucks.
     *
     * Returns array with counts: ['processed' => int, 'updated' => int]
     */
    public function fetchAndUpdate(): array
    {
        $processed = 0;
        $updated = 0;

        if (empty($this->apiKey)) {
            Log::error('FetchLocationService: GLOBAL_TRACK_KEY is not set');
        }

        try {
            $query = http_build_query([
                'key' => $this->apiKey,
                'name' => 1,
                'top' => 5000,
            ]);

            $url = $this->baseurl . '?' . $query;

            $response = Http::timeout(6000)->get($url);



            if ($response->failed()) {
                Log::error('FetchLocationService: failed to fetch XML', ['status' => $response->status()]);
            }

            $body = $response->body();
            if (empty($body)) {
                Log::warning('FetchLocationService: empty response body');
            }

            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($body);
            if ($xml === false) {
                Log::error('FetchLocationService: invalid XML', ['errors' => libxml_get_errors()]);
                libxml_clear_errors();
                return compact('processed', 'updated');
            }

            $truckMap = Truck::pluck('id', 'unitname')->toArray();
     $truckUpdates = [];
            // Loop rows - only get unit_name, position_text and datetime
            foreach ($xml->row ?? [] as $row) {
                $processed++;

                $unitName = trim((string) ($row->unit_name ?? ''));
                $positionText = trim((string) ($row->position_text ?? ''));
                $datetime = trim((string) ($row->datetime ?? ''));

                // require both unit name and position text per your request
                if ($unitName === '' || $positionText === '') {
                    continue;
                }

                if (!isset($truckMap[$unitName])) {
                    continue;
                }

                $truckId = $truckMap[$unitName];

                $affected = Repair::where('truck_id', $truckId)
                    ->where('status', '!=', 'completed')
                    ->update([
                        'location'        => $positionText,
                        'last_reported_at' => $datetime,
                        'last_check_at'   => now(),
                    ]);

                $updated += $affected;

                if (!isset($truckUpdates[$truckId]) || $datetime > $truckUpdates[$truckId]) {
                    $truckUpdates[$truckId] = $datetime;
                }
            }

            foreach ($truckUpdates as $truckId => $datetime) {
                Truck::where('id', $truckId)->update([
                    'last_reported_at' => $datetime,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('FetchLocationService exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return compact('processed', 'updated');
    }
}
