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


        //  calculates the date 30 days prior to the current date
        $last30days = Carbon::now()->subDays(30)->startOfDay();

        // fault types that the system is concerned with / want to display
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

        /**
         *  get faults from the database along with their associated
         *  pending repairs. Eager load repairs related to
         *  faults that have a pending status and gets related truck
         *  information.
         */

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

        // trucks repaired more than twice in the last 30 days
        $topTrucks = Truck::withCount([
            'repairs as completed_repairs' => fn($q) =>
            $q->where('status', 'completed')
                ->where('repairedondate', '>=', $last30days)
        ])
            ->having('completed_repairs', '>=', 2)
            ->orderByDesc('completed_repairs')
            ->get();


        /**
         * Distance Calibration:
         * This part compiles distance calibrations by truck make(fld /shacman / argosy etc):
         * Eager Loads:gets distance calibration records along with the truck data.
         * Grouping: Calibrations are grouped by the truck's make.
         * Counting Unique Trucks: The inner mapping counts unique truck IDs in each group.
         * Sorting: The final result is sorted in descending order.
         */

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
