<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyClient implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clientId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->clientId = $id;
    }

    public function broadcastWith()
    {
        return [
            'Drivers on your way! You\'ll be picked up shortly.'
        ];
    }

    public function broadcastAs()
    {
        return 'notify-client';
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
