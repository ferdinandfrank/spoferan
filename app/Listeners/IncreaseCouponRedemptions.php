<?php

namespace App\Listeners;

use App\Events\CouponRedeemed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncreaseCouponRedemptions {

    /**
     * Create the event listener.
     */
    public function __construct() {
        //
    }

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
