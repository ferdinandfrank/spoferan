<?php

namespace App\Listeners;

use App\Events\CouponRedeemed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * IncreaseCouponRedemptions
 * -----------------------
 * Listener of the coupon redeemed event to increase the coupon redemption count of the redeemed coupon in the database.
 *
 * @see \App\Events\CouponRedeemed
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Listeners
 */
class IncreaseCouponRedemptions {

    /**
     * Handle the event.
     *
     * @param  CouponRedeemed $event
     * @return void
     */
    public function handle(CouponRedeemed $event) {
        $event->coupon->increaseRedemption();
    }
}
