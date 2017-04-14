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

class CouponRedeemed {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $coupon;

    /**
     * Creates a new event instance.
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
