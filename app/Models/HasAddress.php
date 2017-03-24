<?php

namespace App\Models;

/**
 * HasAddress
 * -----------------------
 * Type of @link Model that has address column names.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait HasAddress {

    /**
     * Gets the full address of the model as a string.
     *
     * @return string
     */
    public function getFullAddress() {
        $address = '';
        if (isset($this->street)) {
            $address .= $this->street . ', ';
        }

        if (isset($this->postcode)) {
            $address .= $this->postcode . ' ';
        }

        if (isset($this->city)) {
            $address .= $this->city . ', ';
        }

//        if (isset($this->state)) {
//            $address .= $this->state . ', ';
//        }

        if (isset($this->country)) {
            $address .= trans('countries.' . $this->country);
        }

        return $address;
    }
}