<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $cutoff = now()->subDay(); // 24 hours ago

        $inactiveReportingTrucks = Truck::query()
            ->where('status', 1) // active trucks only
            ->where('unitname', '!=', 'LEOCC28')
            ->where(function ($query) use ($cutoff) {
                $query
                    ->whereNull('last_reported_at')           // never reported
                    ->orWhere('last_reported_at', '<', $cutoff); // reported long ago
            })
            ->orderBy('last_reported_at', 'asc')
            ->get()
            ->map(function ($truck) {
                $truck->days_without_report = $truck->last_reported_at
             ? Carbon::parse($truck->last_reported_at)->startOfDay()->diffInDays(now()->startOfDay())
                    : null;

                return $truck;
            });

        return Inertia::render('Dashboard', [
            'inactiveReportingTrucks' => $inactiveReportingTrucks,
            'inactiveReportingCount'  => $inactiveReportingTrucks->count(),
        ]);
    }
}
