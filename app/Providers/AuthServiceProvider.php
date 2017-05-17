<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * AuthServiceProvider
 * -----------------------
 * Service provider to register all policy classes for the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Coupon::class             => \App\Policies\CouponPolicy::class,
        \App\Models\ParticipationClass::class => \App\Policies\ParticipationClassPolicy::class,
        \App\Models\Participation::class      => \App\Policies\ParticipationPolicy::class,
        \App\Models\Event::class              => \App\Policies\EventPolicy::class,
        \App\Models\User::class               => \App\Policies\UserPolicy::class,
    ];

    /**
     * Registers any authentication / authorization services.
     */
    public function boot() {
        $this->registerPolicies();
    }
}
