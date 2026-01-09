<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Truck extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

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
