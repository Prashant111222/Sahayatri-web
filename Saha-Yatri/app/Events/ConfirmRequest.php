<?php

namespace App\Events;

use App\Models\Ride;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $name;
    public $rideId;
    public $amount;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->userId = $details['id'];
        $this->name = $details['name']['name'];
        $this->rideId = $details['ride'];

        $this->amount = Ride::where('id', $this->rideId)->pluck('total_fare')->first();
    }

    public function broadcastWith()
    {
        //returning the name of the driver from the channel
        return[
            $this->name, $this->rideId, $this->amount
        ];
    }

    public function broadcastAs()
    {
        return 'confirm-request';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('client.'.$this->userId);
    }
}
