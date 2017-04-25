<?php

namespace App\Providers;

use App\Console\Commands\PolicyMakeCommand;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Queue;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
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
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
