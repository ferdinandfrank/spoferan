<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * UserCreated
 * -----------------------
 * Event that gets triggered as soon as a new user gets inserted into the database.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Events
 */
class UserCreated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The created user.
     *
     * @var User
     */
    public $user;

    /**
     * Creates a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Gets the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
