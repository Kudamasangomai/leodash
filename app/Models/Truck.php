<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $days_without_report
 */
class Truck extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    //automatically include in JSON output
    protected $appends = ['days_without_report'];

    /**
     * Returns how many days the truck hasn't reported.
     */
    public function getDaysWithoutReportAttribute(): ?int
    {
        if (! $this->last_reported_at) {
            return null;
        }

         return (int) Carbon::parse($this->last_reported_at)
            ->startOfDay()
            ->diffInDays(now()->startOfDay());
    }
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }
    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->where('status', 1)
                ->orderBy('unitname');
        });
    }
}
