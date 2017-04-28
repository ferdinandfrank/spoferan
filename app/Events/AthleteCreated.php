<?php

namespace App\Events;

use App\Models\Athlete;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * AthleteCreated
 * -----------------------
 * Event that gets triggered as soon as a new athlete gets inserted into the database.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Events
 */
class AthleteCreated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The created athlete.
     *
     * @var Athlete
     */
    public $athlete;

    /**
     * Creates a new event instance.
     *
     * @param Athlete $athlete
     */
    public function __construct(Athlete $athlete) {
        $this->athlete = $athlete;
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
