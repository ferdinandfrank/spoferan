<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * BroadcastServiceProvider
 * -----------------------
 * Service provider to register any broadcast routes for the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class BroadcastServiceProvider extends ServiceProvider {

    /**
     * Bootstraps any application services.
     */
    public function boot() {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
