<?php

namespace App\Services;

use App\Models\Fault;
use Carbon\Carbon;

class FaultsStatsService
{
    public function faultstats()
    {

        $last30days = Carbon::now()->subDays(30)->startOfDay();

        $faults = [
         'gt_not_reporting',
         'fm_not_reporting',
         'fm_no_trip_data',
         'no_rpm',
         'no_rpm_and_speed',
         'no_speed',
         'gps_speed',
         'faulty_gps',
        ];

        return Fault::with([

            'repairs' => fn($q) => $q->where('status', 'pending')
            ->with('truck')

        ])->whereIn('slug', $faults)
            ->withCount([
                'repairs as total' => fn($q) => $q->where('status','pending'),

                'repairs as totaldone' => fn($q) => $q->where('repairedondate', '>=', $last30days)
                                        ->where('status', 'completed'),
            ])
            ->get()
            ->keyBy('slug');
    }
}
