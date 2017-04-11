<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		\App\Models\Coupon::class => \App\Policies\CouponPolicy::class,
		\App\Models\ParticipationClass::class => \App\Policies\ParticipationClassPolicy::class,
		\App\Models\Participation::class => \App\Policies\ParticipationPolicy::class,
		\App\Models\Athlete::class => \App\Policies\AthletePolicy::class,
		\App\Models\Event::class => \App\Policies\EventPolicy::class,
		\App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        //
    }
}
