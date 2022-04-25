<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RideCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clientId;
    public $name;
    public $driverId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->clientId = $details['client_id'];
        $this->name = $details['name']['name'];
        $this->driverId = $details['driver_id'];
    }

    public function broadcastWith()
    {
        return [
            $this->name, strval($this->driverId)
        ];
    }

    public function broadcastAs()
    {
        return 'ride-completed';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('client.'.$this->clientId);
    }
}
