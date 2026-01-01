<?php

namespace App\Http\Controllers;

use App\Models\FaultyUnit;
use App\Models\Note;
use App\Services\TruckStatusService;
use Inertia\Inertia;
use App\Services\FaultsStatsService;

class DashboardController extends Controller
{
    public function index(TruckStatusService $truckStatusService, FaultsStatsService $faultsStats)
    {

        return Inertia::render('Dashboard', [
            'inactiveReportingTrucks' => $truckStatusService->inactiveReportingTrucks(),
            'inactiveReportingCount'  => $truckStatusService->inactiveReportingTrucks()->count(),
            'faultCounts'             => $faultsStats->faultstats(),
            'notes' =>  Note::orderBy('created_at', 'DESC')->get(),
            'faultyunits' => FaultyUnit::take(15)->get(),

            'chartData' => [
                'labels' => $faultsStats->faultstats()->keys(),   // names of the faults
                'totaldone' => $faultsStats->faultstats()->pluck('totaldone'), // counts
            ]
        ]);
    }
}
