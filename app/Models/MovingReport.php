<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovingReport extends Model
{

    protected $guarded = ['id'];

       protected $casts = [
        'time_sent' => 'datetime',
    ];
}
