<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Queue;
use Stripe\Stripe;

/**
 * AppServiceProvider
 * -----------------------
 * Service provider to setup or register any necessary services, which need to be run on deployment.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstraps any application services.
     */
    public function boot() {
        Stripe::setApiKey(config('services.stripe.secret'));

        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->exception
            // TODO: Send email
            \Log::info('Job ' . $event->job->getName() . ' failed: ' . $event->exception->getMessage());
        });
    }

    /**
     * Registers any application services.
     */
    public function register() {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
