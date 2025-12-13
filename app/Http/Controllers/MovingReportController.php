<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovingReport;
use Carbon\Carbon;
use Inertia\Inertia;

class MovingReportController extends Controller
{
    public function index()
    {


        // These trucks must not be included in the final query their shunt buses
        $excludedTrucks = ['LEOCC07', 'LEOCC26', 'LEOCC57', 'LEOCC62', 'K01', 'H07', 'L12'];


        $locationFilters = [
            'chirundu' => 'Chirundu',
            'manica customs' => 'Manica Customs',
            'marondera' => 'Marondera',
            'harare' => ' At Harare - Leopack Yard',
            'forbes' => 'Forbes',
            'machipanda' => 'Forbes',
            'lusaka' => 'Lusaka',
            'karoi' => 'Karoi',
            'manica mutare' => 'Mutare',
            'mutare' => 'Mutare',
            'headlands' => 'Headlands',
            'rusape' => 'Rusape',
            'chinhoyi' => 'Chinhoyi',
            'inchope' => 'Inchope',
            'beira' => 'Beira',
            'yard manga' => 'Beira',

        ];

        // 1) Fetch all filtered reports
        // Only include locations from our filter list
        $reports = MovingReport::where('stationary_minutes', '>=', 240)
            ->whereNotIn('asset_name', $excludedTrucks)
            ->where(function ($query) use ($locationFilters) {
                foreach ($locationFilters as $keyword => $name) {
                    $query->orWhere('location', 'LIKE', "%{$keyword}%");
                }
            })
            ->get() // Loop through each record and transform it.
            ->map(function ($item) use ($locationFilters) {
                // Normalize location
                $locLower = strtolower($item->location);

                foreach ($locationFilters as $keyword => $name) {
                    if (str_contains($locLower, $keyword)) {
                        $item->clean_location = $name;
                        break;
                    }
                }

                // Default fallback
                if (!isset($item->clean_location)) {
                    $item->clean_location = $item->location;
                }

                // Convert to Carbon
                $item->time_sent = Carbon::parse($item->time_sent);

                return $item;
            })
            ->groupBy('clean_location')
            ->map(function ($group) {

                $sortedAsc  = $group->sortBy('time_sent');
                $sortedDesc = $group->sortByDesc('time_sent');

                $earliest = $sortedAsc->first();
                $latest   = $sortedDesc->first();

                return [
                    'location'     => $earliest->clean_location,
                    // 'early_trucks' => 1,
                    'total_trucks' => $group->count(),

                    'time_frame'   => $earliest->time_sent->diff($latest->time_sent)->format('%H:%I:%S'),

                    'first_truck'  => $earliest->asset_name,
                    'first_time'   => $earliest->time_sent->format('H:i:s'),

                    'last_truck'   => $latest->asset_name,
                    'last_time'    => $latest->time_sent->format('H:i:s'),

                    // take latest 3 trucks sort them ascending by time

                    'last_3'       => $sortedDesc->take(3)->sortBy('time_sent')->map(function ($it) {
                            return [
                                'asset' => $it->asset_name,
                                'time'  => $it->time_sent->format('H:i:s'),
                            ];

                        })
                        ->values()->all(),

                ];
            })
            ->values();
  $v = Carbon::createFromTime(6, 0, 0);
      

          return Inertia::render('EarlyStart/show', [
            'v' => $v,
            'reports'=> $reports
          ]);
    }
}
