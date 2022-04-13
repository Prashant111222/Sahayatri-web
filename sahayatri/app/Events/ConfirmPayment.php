<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmPayment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $name;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->userId = $details['id']->id;
        $this->name = $details['name']->name;
    }

    public function broadcastWith()
    {
        return [
            $this->name
        ];
    }

    public function broadcastAs()
    {
        return 'confirm-payment';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver.'.$this->userId);
    }
}
