<?php

namespace App\Http\Controllers;

use App\Events\CouponRedeemed;
use App\Models\Coupon;
use App\Models\Participation;
use App\Models\User;

/**
 * WebhooksController
 * -----------------------
 * Controller to handle webhook routes like notifications about events from Stripe.
 * -----------------------
 * @author Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class WebhooksController extends Controller {

    /**
     * Handles the events from Stripe.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function handle() {
        $payload = request()->all();

        // Call specific method dependent on the event type
        $method = $this->eventToMethod($payload['type']);
        if (method_exists($this, $method)) {
            return $this->$method($payload);
        }

        return response('Webhook received but not handled.');
    }

    public function eventToMethod($event) {
        return 'on' . studly_case(str_replace('.', '_', $event));
    }

    /**
     * Handles the event from stripe, when a charge was successfully processed.
     *
     * @param $payload
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function onChargeSucceeded($payload) {

        // Get the coupon that was used for the charge
        $metadata = $payload['data']['object']['metadata'];
        $couponId = null;
        $coupon = null;
        if (array_key_exists('coupon_id', $metadata)) {
            $couponId = $payload['data']['object']['metadata']['coupon_id'];
            if ($couponId) {
                $coupon = Coupon::findByKey($couponId)->first();
                if (!$coupon) {
                    $couponId = null;
                }
            }
        }

        // Create the payment with the transmitted data
        $payment = $this->getUserByStripePayload($payload)->payments()->create([
            'amount' => $payload['data']['object']['amount'],
            'fee' => $metadata['fee'],
            'payable_id' => $metadata['payable_id'],
            'payable_type' => $metadata['payable_type'],
            'payment_type' => $payload['data']['object']['source']['object'],
            'charge_id' => $payload['data']['object']['id'],
            'coupon_id' => $couponId,
        ]);

        // Call the coupon redeemed event, if a coupon was used
        if ($coupon) {
            event(new CouponRedeemed($coupon));
        }

        return $payment;
    }

    /**
     * Finds the user by the Stripe id in the specified Stripe payload.
     *
     * @param $stripePayload
     * @return User
     */
    protected function getUserByStripePayload($stripePayload) {
        return User::findByStripeId($stripePayload['data']['object']['customer']);
    }
}
