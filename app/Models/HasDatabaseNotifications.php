<?php

namespace App\Models;

/**
 * HasDatabaseNotifications
 * -----------------------
 * Type of @link Model that can receive database notifications.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasDatabaseNotifications {
    /**
     * Get the entity's notifications.
     */
    public function notifications() {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications() {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}