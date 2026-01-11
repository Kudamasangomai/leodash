<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Truck;
use Illuminate\Support\Facades\Log;

class FetchTruckService
{

    protected string $apiKey;
    protected string $baseurl;


    public function __construct()
    {
        $this->apiKey = config('services.globaltrack.key');
        $this->baseurl = config('services.globaltrack.api_url');
    }

    public function fetchFromXmlApi(): array
    {
        $url = 'https://sa.globalwebtrack.com/ssl/xml/xrs_last_positions.xml';

        if (empty($this->apiKey)) {
            Log::error('FetchLocationService: GLOBAL_TRACK_KEY is not set');
              return [
            'total' => 0,
            'inserted' => 0,
        ];
        }

        try {
            $query = http_build_query([
                'key' => $this->apiKey,
                'name' => 1,
                'top' => 5000,
            ]);

            $url = $this->baseurl . '?' . $query;

            $response = Http::timeout(60)->get($url);


            if (! $response->successful()) {
                throw new \Exception('Failed to fetch truck XML: HTTP ' . $response->status());
            }

            $xmlString = $response->body();
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlString);

            if (! $xml) {
                throw new \Exception('Invalid XML returned from truck API.');
            }

            $rows = $xml->row ?? [];
            $total = count($rows);
            $inserted = 0;

            foreach ($rows as $row) {
                $unitName = trim((string) ($row->unit_name ?? ''));

                if ($unitName === '') {
                    continue;
                }

                // case-insensitive existence check
                $exists = Truck::whereRaw('LOWER(unitname) = ?', [strtolower($unitName)])->exists();

                if ($exists) {
                    continue;
                }

                // create minimal record; adjust attributes if your Truck model needs more
                Truck::create(['unitname' => $unitName]);
                $inserted++;
            }
        } catch (\Throwable $e) {
            Log::error('FetchLocationService exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return ['total' => $total, 'inserted' => $inserted];
    }
}
