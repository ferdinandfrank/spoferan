<?php

namespace App\Events;

use App\Models\Coupon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * CouponRedeemed
 * -----------------------
 * Event that gets triggered as soon as a coupon code gets redeemed.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Events
 */
class CouponRedeemed {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The redeemed coupon.
     *
     * @var Coupon
     */
    public $coupon;

    /**
     * Creates a new event instance.
     *
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon) {
        $this->coupon = $coupon;
    }

    /**
     * Gets the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
