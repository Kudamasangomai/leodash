<?php

namespace App\Http\Controllers;

use App\Models\Fault;
use App\Models\Repair;
use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $cutoff = now()->subDay();
        // just delete truck from truck tables
        $excludedTrucks = ['LEOCC28', 'LEO012', 'LEO261', 'LEO114', 'LEO059', 'h19', 'LEO013'];


        $inactiveReportingTrucks = Truck::query()
            ->where('status', 1)
            ->whereNotIn('unitname', $excludedTrucks)
            ->where(function ($query) use ($cutoff) {
                $query
                    ->whereNull('last_reported_at')
                    ->orWhere('last_reported_at', '<', $cutoff);
            })
            ->orderBy('last_reported_at', 'asc')
            ->get()
            ->map(function ($truck) {
                $truck->days_without_report = $truck->last_reported_at
                    ? Carbon::parse($truck->last_reported_at)->startOfDay()->diffInDays(now()->startOfDay()) : null;

                return $truck;
            });

        $faultCounts = Fault::withCount([
            'repairs as total' => fn($q) =>
            $q->where('status', '!=', 'completed')
        ])
            ->pluck('total', 'name');

        return Inertia::render('Dashboard', [
            'inactiveReportingTrucks' => $inactiveReportingTrucks,
            'inactiveReportingCount'  => $inactiveReportingTrucks->count(),
            'faultCounts'             => $faultCounts,
        ]);
    }
}
