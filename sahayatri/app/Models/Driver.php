<?php

namespace App\Models;
use App\Models\Vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_no',
        'availability', 
        'status',
    ];

    // DB::table('users')
        // ->where('type', '=', 'driver')
        // ->join('drivers', 'users.id', '=', 'drivers.user_id')
        // ->join('vehicles', 'drivers.id', '=', 'vehicles.driver_id')
        // ->join('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.id')

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }
}
