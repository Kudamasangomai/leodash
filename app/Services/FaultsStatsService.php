<?php

namespace App\Services;

use App\Models\Fault;

class FaultsStatsService
{
    public function faultstats()
    {
        return Fault::with([
            'repairs' => fn($q) =>
            $q->where('status', '!=', 'completed')
                ->with('truck')
        ])
            ->withCount([

                'repairs as total' => fn($q) =>
                $q->where('status', 'completed'),

            ])
            ->get()
            ->keyBy('name');
    }
}
