<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Fault extends Model
{
    use Sluggable;
    protected $guarded = ['id'];
       public function repairs()
    {
        return $this->hasMany(Repair::class, 'fault_id');
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

      public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }
}

