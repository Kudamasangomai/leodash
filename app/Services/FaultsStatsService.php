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
                $q->where('status', '!=', 'completed'),

                // 👇 NEW (won’t affect frontend)
                'repairs as completed_count' => fn($q) =>
                $q->where('status', 'completed'),

                'repairs as pending_count' => fn($q) =>
                $q->where('status', 'pending'),
            ])
            ->get()
            ->keyBy('name');
    }
}
