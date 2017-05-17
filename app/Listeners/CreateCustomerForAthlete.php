<?php

namespace App\Listeners;

use App\Events\AthleteCreated;
use Stripe\Customer;

/**
 * CreateCustomerForAthlete
 * -----------------------
 * Listener of the athlete created event to create a Stripe customer for the created athlete.
 *
 * @see \App\Events\AthleteCreated
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Listeners
 */
class CreateCustomerForAthlete {

    /**
     * Handle the event.
     *
     * @param  AthleteCreated $event
     */
    public function handle(AthleteCreated $event) {
        $user = $event->athlete->user;
        try {
            $customer = Customer::create([
                'email' => $user->email,
                'metadata' => [
                    'id' => $user->getKey(),
                    'user_type' => $user->user_type
                ],
                'shipping' => [
                    'name' => $user->getDisplayName(),
                    'phone' => $user->phone,
                    'address' => [
                        'line1' => $user->getFullAddress(),
                        'city' => $user->city,
                        'postal_code' => $user->postcode,
                        'country' => $user->country
                    ]
                ]
            ]);

            $user->paymentDetails()->create([
                'stripe_id' => $customer->id,
                'stripe_object' => $customer->object
            ]);
        } catch (\Exception $exception) {
            \Log::alert("Stripe customer creation failed for user $user->id: " . $exception->getMessage());
        }
    }
}
