<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * CreateUserRelatedTables
 * -----------------------
 * Listener of the user created event to create the user related database entries.
 *
 * @see \App\Events\UserCreated
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Listeners
 */
class CreateUserRelatedTables {

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
