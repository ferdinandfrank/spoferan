<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * EventServiceProvider
 * -----------------------
 * Service provider to register all events and their listeners for the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AthleteCreated'   => [
            'App\Listeners\CreateCustomerForAthlete',
        ],
        'App\Events\OrganizerCreated' => [
            'App\Listeners\CreateAccountForOrganizer',
        ],
        'App\Events\UserCreated'      => [
            'App\Listeners\CreateUserRelatedTables',
        ],
        'App\Events\CouponRedeemed'   => [
            'App\Listeners\IncreaseCouponRedemptions',
        ]
    ];

    /**
     * Registers any events for your application.
     */
    public function boot() {
        parent::boot();
    }
}
