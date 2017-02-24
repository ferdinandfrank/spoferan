<?php

namespace App\Models;

/**
 * HasAddress
 * -----------------------
 * Type of @link Model that has address column names.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasAddress {

    /**
     * Gets the full address of the model as a string.
     *
     * @return string
     */
    public function getFullAddress() {
        return $this->street . ', ' . $this->postcode . ' ' . $this->city . ', ' . $this->country;
    }
}