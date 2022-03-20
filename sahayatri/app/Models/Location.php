<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'initial_lat',
        'initial_lng',
        'destination_lat',
        'destination_lng',
        'origin',
        'destination',
        'total_distance',
    ];
}
