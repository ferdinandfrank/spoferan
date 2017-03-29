<?php

namespace App\Listeners;

use App\Events\AthleteCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Stripe\Customer;

class CreateCustomerForAthlete {

    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AthleteCreated $event
     *
     * @return void
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
            $user->paymentDetails()->update([
                'stripe_id' => $customer->id
            ]);
        } catch (\Exception $exception) {
            \Log::alert("Customer creation failed for user $user->id: " . $exception->getMessage());
        }
    }
}
