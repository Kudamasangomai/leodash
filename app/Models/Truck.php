<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\CodeCoverage\Node\Builder;
use Illuminate\Database\Eloquent\Model;


class Truck extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];


    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
                $query->where('status', 1)    
                  ->orderBy('unitname');
        });
    }
}
