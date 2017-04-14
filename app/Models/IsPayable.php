<?php

namespace App\Models;

/**
 * IsPayable
 * -----------------------
 * ${CARET}
 * -----------------------
 * @author Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */

trait IsPayable {

    /**
     * Get all of the model's payments.
     */
    public function payment() {
        return $this->morphOne(Payment::class, 'payable');
    }
}