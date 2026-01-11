<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fault extends Model
{
    use Sluggable, HasFactory;

    protected $guarded = ['id'];
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class, 'fault_id');
    }

      public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => false,
                'separator' => '_',
            ]
        ];
    }

       protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('name');
        });
    }

}

