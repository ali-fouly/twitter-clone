<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActionTrigerred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id, $action, $tweet_id, $mentioned_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $action, $tweet_id, $mentioned_id = null)
    {
        $this->user_id = $user_id;
        $this->action = $action;
        $this->tweet_id = $tweet_id;
        $this->mentioned_id = $mentioned_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
