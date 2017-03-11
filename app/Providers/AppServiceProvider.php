<?php

namespace App\Providers;

use App\Console\Commands\PolicyMakeCommand;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
