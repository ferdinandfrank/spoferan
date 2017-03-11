<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use App\Models\User;

class WebhooksController extends Controller {

    public function handle() {
        $payload = request()->all();

        $method = $this->eventToMethod($payload['type']);

        if (method_exists($this, $method)) {
            return $this->$method($payload);
        }

        return response('Webhook received but not handled.');
    }

    public function eventToMethod($event) {
        return 'on' . studly_case(str_replace('.', '_', $event));
    }

    public function onChargeSucceeded($payload) {
        $payment = $this->getUserByStripePayload($payload)->payments()->create([
            'amount' => $payload['data']['object']['amount'],
            'charge_id' => $payload['data']['object']['id'],
            'description' => $payload['data']['object']['description']
        ]);

        $participationId = $payload['data']['object']['metadata']['participation_id'];
        if ($participationId) {
            $participation = Participation::find($participationId);
            if ($participation) {
                $participation->payment_id = $payment->id;
                $participation->save();
            }
        }

        return $payment;
    }

    protected function getUserByStripePayload($stripePayload) {
        return User::findByStripeId($stripePayload['data']['object']['customer']);
    }
}
