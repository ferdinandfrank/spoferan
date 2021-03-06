<?php

namespace App\Listeners;

use App\Events\OrganizerCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Stripe\Account;

/**
 * CreateAccountForOrganizer
 * -----------------------
 * Listener of the organizer created event to create a Stripe account for the created organizer.
 *
 * @see \App\Events\OrganizerCreated
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Listeners
 */
class CreateAccountForOrganizer {

    /**
     * Handle the event.
     *
     * @param  OrganizerCreated $event
     */
    public function handle(OrganizerCreated $event) {
        $organizer = $event->organizer;
        $user = $organizer->user;
        try {
            $account = Account::create(array(
                'managed' => true,
                'country' => 'DE',
                'email' => $user->email,
                'business_name' => $organizer->name,
                'metadata' => [
                    'id' => $user->getKey(),
                    'user_type' => $user->user_type
                ],
            ));

            $user->paymentDetails()->create([
                'stripe_id' => $account->id,
                'stripe_object' => $account->object
            ]);
        } catch (\Exception $exception) {
            \Log::alert("Stripe account creation failed for user $user->id: " . $exception->getMessage());
        }
    }
}
