<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $days_without_report
 */
class Repair extends Model
{

    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['days_without_report'];

    protected $casts = [
        'reported_at' => 'datetime',
        'checked_at' => 'datetime',

    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function doneBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'done_by');
    }

    public function fault(): BelongsTo
    {
        return $this->belongsTo(Fault::class);
    }

    public static function hasPendingRepair($fault_id, $truck_id)
    {
        if (self::where('fault_id', $fault_id)
            ->where('truck_id', $truck_id)
            ->wherestatus('pending')
            ->exists())
        {
            return 'The Truck with that fault  already has a pending repair.';
        }
        return null;
    }


    /**
     * Computed Attribute
     * Calculates how many days this truck has gone without a report.
     */
    public function getDaysWithoutReportAttribute(): ?int
    {
        if (!$this->last_reported_at) {
            return 0;
        }
        return (int) Carbon::parse($this->last_reported_at)
            ->startOfDay()
            ->diffInDays(now()->startOfDay());
    }

    public function scopeSearch($query, $q)
    {
        $query->when($q, function ($query) use ($q) {
            $query->where(function ($query) use ($q) {
                $query->whereHas('truck', function ($query) use ($q) {
                    $query->where('unitname', 'like', "%{$q}%");
                })
                    ->orWhereHas('fault', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            });
        });
    }
}
