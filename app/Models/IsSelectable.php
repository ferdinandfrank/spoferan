<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;

/**
 * IsSelectable
 * -----------------------
 * Type of @link Model that has a boolean selectable column in the database.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */

trait IsSelectable {

    /**
     * Scopes a query with including only confirmed users.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeIsSelectable($query) {
        return $query->where('selectable', true);
    }
}