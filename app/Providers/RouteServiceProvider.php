<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * RouteServiceProvider
 * -----------------------
 * Service provider to register any web and api routes for the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Defines the route model bindings, pattern filters, etc.
     */
    public function boot() {
        parent::boot();
    }

    /**
     * Defines the routes for the application.
     */
    public function map() {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Defines the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes() {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Defines the "api" routes for the application.
     * These routes are typically stateless.
     */
    protected function mapApiRoutes() {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
