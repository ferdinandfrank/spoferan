<?php

namespace App\Providers;

use App\Http\ViewComposers\PublicComposer;
use Illuminate\Support\ServiceProvider;
use View;

/**
 * ComposerServiceProvider
 * -----------------------
 * Service provider to provide the view composer services for the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstraps any application services.
     */
    public function boot() {
        View::composer('*', PublicComposer::class);
    }

    /**
     * Registers any application services.
     */
    public function register() {

    }
}
