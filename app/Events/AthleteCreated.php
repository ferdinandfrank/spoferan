<?php

namespace App\Events;

use App\Models\Athlete;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class AthleteCreated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The created athlete.
     *
     * @var Athlete
     */
    public $athlete;

    /**
     * Create a new event instance.
     *
     * @param Athlete $athlete
     */
    public function __construct(Athlete $athlete) {
        $this->athlete = $athlete;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
