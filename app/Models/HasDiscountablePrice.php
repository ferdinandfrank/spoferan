<?php

namespace App\Models;

/**
 * HasDiscountablePrice
 * -----------------------
 * Type of @link Model that has a price property on which a discount through a coupon can be set.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait HasDiscountablePrice {

    /**
     * Calculates the price with the specified coupon.
     *
     * @param Coupon|null $coupon
     *
     * @return int
     */
    public function getDiscountPrice(Coupon $coupon = null) {

        $basicPrice = $this[$this->getPriceColumn()];

        if ($coupon && $coupon->isRedeemable()) {
            if ($coupon->amount_off) {
                return round($basicPrice - $coupon->amount_off);
            } elseif ($coupon->percent_off) {
                return round($basicPrice * ($coupon->percent_off / 100));
            }
        }

        return $basicPrice;
    }

    /**
     * Gets the column name that holds the information about the price.
     *
     * @return string
     */
    protected function getPriceColumn() {
        return 'price';
    }
}