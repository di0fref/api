<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExampleEvent extends Event implements ShouldBroadcast
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function broadcastOn()
    {
        return new Channel('test');
    }
    public function broadcastAs()
    {
        return 'UserLookingFor';


        //return new PrivateChannel('test-channel');
    }
}
