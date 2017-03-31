<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserRelatedTables {

    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated $event
     *
     * @return void
     */
    public function handle(UserCreated $event) {
        $user = $event->user;

        // Create settings entry for the user
        $user->settings()->create([]);

        // Create payment details entry for the user
        $user->paymentDetails()->create([]);
    }
}
