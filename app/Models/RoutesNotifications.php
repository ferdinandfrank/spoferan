<?php

namespace App\Models;

use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Str;

/**
 * RoutesNotifications
 * -----------------------
 * Type of @link Model that can receive notifications.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait RoutesNotifications {

    /**
     * Send the given notification.
     *
     * @param  mixed $instance
     * @return void
     */
    public function notify($instance) {
        app(Dispatcher::class)->send([$this], $instance);
    }

    /**
     * Get the notification routing information for the given driver.
     *
     * @param  string $driver
     * @return mixed
     */
    public function routeNotificationFor($driver) {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email;
            case 'nexmo':
                return $this->phone_number;
        }
    }
}