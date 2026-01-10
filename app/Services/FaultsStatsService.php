<?php

namespace App\Services;

use App\Models\DistanceCalibration;
use App\Models\Fault;
use App\Models\Truck;
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

        $faults = Fault::with([

            'repairs' => fn($q) => $q->where('status', 'pending')
                ->with('truck')

        ])->whereIn('slug', $faults)
            ->withCount([
                'repairs as total' => fn($q) => $q->where('status', 'pending'),

                'repairs as totaldone' => fn($q) => $q->where('repairedondate', '>=', $last30days)
                    ->where('status', 'completed'),
            ])
            ->orderByDesc('totaldone')
            ->get()
            ->keyBy('slug');

        // trucks repaired twice in the last 30 days
        $topTrucks = Truck::withCount([
            'repairs as completed_repairs' => fn($q) =>
            $q->where('status', 'completed')
                ->where('repairedondate', '>=', $last30days)
        ])
            ->having('completed_repairs', '>=', 2)
            ->orderByDesc('completed_repairs')
            ->get();


        $distancecalibrationbymake = DistanceCalibration::with('truck')
            ->get()
            ->groupBy(function ($dc) {
                return $dc->truck->make;
            })
            ->map(function ($group) {
                return  $group->pluck('truck_id')->unique()->count();
            })
            ->sortDesc();

        return [
            'faults'     => $faults,
            'topTrucks'  => $topTrucks,
            'distancecalibrationbymake'  => $distancecalibrationbymake
        ];
    }
}
