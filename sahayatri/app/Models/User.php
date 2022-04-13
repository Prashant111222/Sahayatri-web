<?php

namespace App\Models;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Rating;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //creating attributes to be returned
    protected $appends = [
        'avg_rating'
    ];

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    //returning the average rating from rating column of the rating model
    function getAvgRatingAttribute(){
        return round($this->rating()->avg('rating', 'rating'), 1);
    }
}
