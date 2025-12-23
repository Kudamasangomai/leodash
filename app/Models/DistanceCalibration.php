<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistanceCalibration extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date_went_to_roadtest' => 'datetime',
        'road_test_done' => 'boolean',
    ];

    /**
     * Format date_went_to_roadtest for display, handling null values.
     */
    public function getDateWentToRoadtestAttribute($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        return Carbon::parse($value)->format('d M Y');
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        return Carbon::parse($value)->format('d M Y');
    }

    /**
     * Get the truck associated with this calibration.
     */
    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    /**
     * Get the user who created this calibration record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
