<?php

namespace App\Models;
use App\Models\Payment;
use App\Models\Location;
use App\Models\Client;
use App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'driver_id',
        'ride_type',
        'scheduled_date',
        'scheduled_time',
        'total_fare',
        'status',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
