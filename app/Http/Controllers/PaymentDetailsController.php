<?php

namespace App\Http\Controllers;

use App\Models\PaymentDetails;
use Exception;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Source;
use Stripe\Token;

class PaymentDetailsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentDetails            $paymentDetails
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentDetails $paymentDetails, Request $request) {
        $customer = Customer::retrieve($paymentDetails->stripe_id);

        $data = $request->toArray();
        $type = $data['type'];
        unset($data['type']);
        $name = $data['name'];
        unset($data['name']);

        try {
            if ($type == 'card') {
                $expiry = explode(' / ', $data['expiry']);
                unset($data['expiry']);
                $source = $customer->sources->create([
                    'source' => array_merge($data, [
                        'object'    => $type,
                        'name'      => $name,
                        'exp_month' => $expiry[0],
                        'exp_year'  => $expiry[1]
                    ])
                ]);
            } else {
                Source::create([
                        "type"     => $type,
                        $type      => $data,
                        "currency" => "eur",
                        "owner"    => [
                            "name" => $name,
                        ]
                    ]
                );
            }

        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err = $body['error'];

            return response()->json(['msg' => trans('validation.credit_card.' . $err['code'])], 422);
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return response()->json(['msg' => $e->getMessage()], 422);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return response()->json(['msg' => $e->getMessage()], 422);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return response()->json(['msg' => $e->getMessage()], 422);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return response()->json(['msg' => $e->getMessage()], 422);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return response()->json(['msg' => $e->getMessage()], 422);
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 422);
        }

        return response()->json($source);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentDetails $paymentDetails
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentDetails $paymentDetails) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentDetails $paymentDetails
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentDetails $paymentDetails) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \App\Models\PaymentDetails $paymentDetails
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentDetails $paymentDetails) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentDetails $paymentDetails
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentDetails $paymentDetails) {
        //
    }
}
