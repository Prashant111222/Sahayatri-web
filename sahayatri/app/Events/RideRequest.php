<?php

namespace App\Events;

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
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($driver_id)
    {
        //
        $this->driver_id = $driver_id;
    }

    public function broadcastWith()
    {
        return[
            'Your Request has been confirmed'
        ];
    }

    public function broadcastAs()
    {
        return 'test-test';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('test.'.$this->driver_id->id);
    }
}
