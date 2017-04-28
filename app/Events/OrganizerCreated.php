<?php

namespace App\Events;

use App\Models\Organizer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * OrganizerCreated
 * -----------------------
 * Event that gets triggered as soon as a new organizer gets inserted into the database.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Events
 */
class OrganizerCreated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The created organizer.
     *
     * @var Organizer
     */
    public $organizer;

    /**
     * Creates a new event instance.
     *
     * @param Organizer $organizer
     */
    public function __construct(Organizer $organizer) {
        $this->organizer = $organizer;
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
