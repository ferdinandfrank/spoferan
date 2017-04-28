<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * RedirectIfAuthenticated
 * -----------------------
 * Middleware to redirect authenticated users, if they visit a page that can only be visited
 * unauthorized, e.g. login page.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated {

    /**
     * Handles an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
