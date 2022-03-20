<?php

namespace App\Events;

use App\Models\User;
use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driver_id;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        // 
        $this->driver_id = $data['driver_id'];
        $this->data = $data;
    }

    public function broadcastWith()
    {
        $details = User::where('id', $this->data['client_id'])
        ->withAvg('rating', 'rating')
        ->first()
        ->toArray();

        $rideInfo = Ride::where('id', $this->data['ride_id'])
        ->with('location')
        ->first()
        ->toArray();

        return ['user' => $details, 'ride' => $rideInfo];
    }

    public function broadcastAs()
    {
        return 'ride-request';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.'.$this->driver_id);
    }
}
