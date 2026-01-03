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
        $faultsStats = $faultsStats->faultstats();

        return Inertia::render('Dashboard', [
            'inactiveReportingTrucks' => $truckStatusService->inactiveReportingTrucks(),
            'inactiveReportingCount'  => $truckStatusService->inactiveReportingTrucks()->count(),
            'faultCounts'             => $faultsStats,
            'notes' =>  Note::orderBy('created_at', 'DESC')->take(15)->get(),
            'faultyunits' => FaultyUnit::take(15)->get(),
            'chartData' => [
                 'labels' => $faultsStats->map(fn($fault) => $fault->name)->values(),
                'totaldone' => $faultsStats->pluck('totaldone'),
            ]
        ]);
    }
}
