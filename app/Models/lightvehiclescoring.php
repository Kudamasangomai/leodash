<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class lightvehiclescoring extends Model
{
    protected $guarded = ['id'];

    protected $appends = [
        'total_duration_time',
        'greenband_duration_time',
        'idle_duration_time',
    ];

    protected function formatSeconds(?int $seconds): ?string
    {
        if ($seconds === null) {
            return null;
        }

        return CarbonInterval::seconds($seconds)
            ->cascade()
            ->format('%H:%I:%S');
    }
    public function getTotalDurationTimeAttribute()
    {
        return $this->formatSeconds($this->total_duration ?? null);
    }

    public function getGreenbandDurationTimeAttribute()
    {
        return $this->formatSeconds($this->greenband_duration ?? null);
    }

    public function getIdleDurationTimeAttribute()
    {
        return $this->formatSeconds($this->idle_duration ?? null);
    }
}
