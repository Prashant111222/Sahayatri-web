<?php

namespace App\Models;
use App\Models\Vehicle;
use App\Models\Rating;
use App\Models\Ride;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_no',
        'license',
        'availability', 
        'status',
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function ride()
    {
        return $this->hasMany(Ride::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
