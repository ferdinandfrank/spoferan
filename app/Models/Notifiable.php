<?php

namespace App\Models;

/**
 * Notifiable
 * -----------------------
 * Type of @link Model that can receive notifications.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */

trait Notifiable {
    use HasDatabaseNotifications, RoutesNotifications;
}