<?php

namespace App\Services;
use App\Models\Fault;

class FaultsStatsService
{
    public function faultstats()
    {
        return Fault::with([
            'repairs.truck' => fn($q) =>
            $q->where('status', '!=', 'completed')
        ])
            ->withCount([
                'repairs as total' => fn($q) =>
                $q->where('status', '!=', 'completed')
            ])
            ->get()
            ->keyBy('name');
    }
}
