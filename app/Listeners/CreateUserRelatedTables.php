<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserRelatedTables {

    /**
     * Creates the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handles the event.
     *
     * @param  UserCreated $event
     */
    public function handle(UserCreated $event) {
        $user = $event->user;

        // Create settings entry for the user
        $user->settings()->create([]);

        // Create contact entry for the user
        $user->contact()->create([]);
    }
}
