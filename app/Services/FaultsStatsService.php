<?php

namespace App\Services;

use App\Models\Fault;
use Carbon\Carbon;

class FaultsStatsService
{
    public function faultstats()
    {

        $last30days = Carbon::now()->subDays(30)->startOfDay();
        $faults = ['Gt Not Reporting', 'Fm Not Reporting', 'Fm No Trip Data', 'No Rpm', 'No Rpm and Speed', 'No Speed', 'Gps Speed'];
        return Fault::with([
            'repairs' => fn($q) => $q->where('status', '!=', 'completed')->with('truck')
        ])->whereIn('name', $faults)
            ->withCount([
                'repairs as total' => fn($q) => $q->where('repairedondate', '>=', $last30days)->where('status', '!=', 'completed'),
                'repairs as totaldone' => fn($q) => $q->where('repairedondate', '>=', $last30days)->where('status', 'completed'),
            ])
            ->get()
            ->keyBy('name');
    }
}
