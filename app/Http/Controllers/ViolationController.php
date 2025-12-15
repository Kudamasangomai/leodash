<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{

    public function index()
    {
        return Inertia::render('Violations/violations');
    }

    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt|max:2048',
        ]);

        $path = $request->file('file')->storeAs('speeding-reports');

        $rows = array_map('str_getcsv', file(storage_path("app/$path")));
        $header = array_map('trim', array_shift($rows));

        $data = collect($rows)
            ->filter(fn($row) => count($row) === count($header)) // safety
            ->map(function ($row) use ($header) {
                return array_combine($header, $row);
            })
            ->map(function ($row) {
                $row['EventValue'] = (float) $row['EventValue'];
                return $row;
            });

        /**
         * Get highest EventValue per Asset + EventType
         */
        $summary = $data
            ->groupBy(fn($row) => $row['AssetName'] . '_' . $row['EventType'])
            ->map(function ($events) {
                $max = $events->sortByDesc('EventValue')->first();

                return [
                    'date'        => $max['EventStartDate'],
                    'asset'       => $max['AssetName'],
                    'event_type'  => $max['EventType'],
                    'driver'      => $max['AssetName2'] ?? 'Unknown',
                    'location'    => $max['EventLocation'],
                    'duration'    => $max['TotalDuration'],
                    'max_speed'   => $max['EventValue'],
                    'destination' => $max['F_EndTown'] ?? null,
                    'coordinates' => $max['EndLatLong'] ?? null,
                ];
            })
            ->values();

        DB::transaction(function () use ($summary) {
            foreach ($summary as $row) {
                Violation::updateOrCreate(
                    [
                        'date'       => $row['date'],
                        'asset'      => $row['asset'],
                        'event_type' => $row['event_type'],
                    ],
                    [
                        'driver'      => $row['driver'],
                        'location'    => $row['location'],
                        'duration'    => $row['duration'],
                        'max_speed'   => $row['max_speed'], // ✅ FIXED
                        'destination' => $row['destination'],
                        'coordinates' => $row['coordinates'],
                    ]
                );
            }
        });

        return response()->json([
            'message' => 'Speeding report processed successfully',
            'count'   => $summary->count(),
            'data'    => $summary,
        ]);
    }
}
