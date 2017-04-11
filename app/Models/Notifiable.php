<?php

namespace App\Models;

/**
 * Notifiable
 * -----------------------
 * Type of @link Model that can receive notifications.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */

trait Notifiable {
    use HasDatabaseNotifications, RoutesNotifications;
}