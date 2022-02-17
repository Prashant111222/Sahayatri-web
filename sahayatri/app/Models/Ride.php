<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'driver_id',
        'initial_lat', 
        'initial_lng',
        'destination_lat',
        'destination_lng',
        'ride_type',
        'scheduled_date',
        'scheduled_time',
        'total_fare',
        'status',
    ];
}
