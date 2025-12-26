<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Truck;
use Carbon\Carbon;


class TruckStatusService
{

    public function inactiveReportingTrucks()
    {
        $cutoff = now()->subDay();

        $excludedTrucks = [
            'LEOCC28',
            'LEO012',
            'LEO261',
            'LEO114',
            'LEO059',
            'h19',
            'LEO013'
        ];

        return Truck::query()
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
                    ? Carbon::parse($truck->last_reported_at)
                    ->startOfDay()
                    ->diffInDays(now()->startOfDay())
                    : null;

                return $truck;
            });
    }
}
