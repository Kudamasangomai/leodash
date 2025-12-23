<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fault extends Model
{
    protected $guarded = ['id'];
       public function repairs()
    {
        return $this->hasMany(Repair::class, 'fault_id');
    }
}
