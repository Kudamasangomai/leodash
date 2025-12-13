<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repair extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'reported_at' => 'datetime',
        'checked_at' => 'datetime',
    ];

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fault()
    {
        return $this->belongsTo(Fault::class);
    }

      public static function hasPendingReapir($fault_id, $truck_id)
    {
        if (
            self::where('fault_id', $fault_id)
                ->where('truck_id', $truck_id)
                ->wherestatus('pending')
            ->exists()
        ) {
            return 'The Truck with that fault  already have a pending repair.';
        }


        return null;
    }
}
