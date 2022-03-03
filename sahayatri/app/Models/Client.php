<?php

namespace App\Models;
use App\Models\Ride;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    public function ride()
    {
        return $this->hasMany(Ride::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}
