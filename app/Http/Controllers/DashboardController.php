<?php

namespace App\Http\Controllers;

use App\Models\FaultyUnit;
use App\Models\Note;
use App\Services\TruckStatusService;
use Inertia\Inertia;
use App\Services\FaultsStatsService;

class DashboardController extends Controller
{
    public function __invoke(TruckStatusService $truckStatusService, FaultsStatsService $faultsStats)
    {
        $stats = $faultsStats->faultstats();

        return Inertia::render('Dashboard', [
            'inactiveReportingTrucks' => $truckStatusService->inactiveReportingTrucks(),
            'inactiveReportingCount'  => $truckStatusService->inactiveReportingTrucks()->count(),
            'faultCounts'             => $stats['faults'],
            'topTrucks' => $stats['topTrucks'],
            'distancecalibrationbymake'=>  $stats['distancecalibrationbymake'],
            'notes' =>  Note::orderBy('created_at', 'DESC')->take(15)->get(),
            'faultyunits' => FaultyUnit::take(15)->get(),
            'chartData' => [
                'labels' => $stats['faults']->map(fn($fault) => $fault->name)->values(),
                'totaldone' => $stats['faults']->pluck('totaldone')->values(),
            ]
        ]);
    }
}
