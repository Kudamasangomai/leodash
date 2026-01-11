<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string|null $clean_location
 */
class MovingReport extends Model
{

    protected $guarded = ['id'];

       protected $casts = [
        'time_sent' => 'datetime',
    ];
}
