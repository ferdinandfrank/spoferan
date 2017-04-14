<?php

namespace App\Http\Controllers;

use App;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Participation;
use App\Http\Requests\ParticipationCreateRequest;
use App\Models\ParticipationClass;
use App\Models\ParticipationState;
use Barryvdh\DomPDF\PDF;
use DB;
use Exception;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

/**
 * ParticipationController
 * -----------------------
 * Controller to handle the participation routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class ParticipationController extends Controller {

    /**
     * Displays a listing of all the participations.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('participation.index');
    }

    /**
     * Displays the specified participation.
     *
     * @param Event $event
     * @param Participation $participation
     * @return \Illuminate\View\View
     */
    public function show(Event $event, Participation $participation) {
        if (\Gate::denies('view', $participation)) {
            abort(404, 'Page not found.');
        }

        $event = $participation->participationClass->event;
        $childEvent = null;
        if ($event->isChild()) {
            $childEvent = $event;
            $event = $event->parentEvent;
        }

        return view('participation.show', compact('participation', 'event', 'childEvent'));
    }

    /**
     * Downloads the specified participation.
     *
     * @param Event $event
     * @param Participation $participation
     * @return \Illuminate\Http\Response
     */
    public function download(Event $event, Participation $participation) {
        if (\Gate::denies('view', $participation)) {
            abort(404, 'Page not found.');
        }

        $event = $participation->participationClass->event;
        $childEvent = null;
        if ($event->isChild()) {
            $childEvent = $event;
            $event = $event->parentEvent;
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('participation.download', ['participation' => $participation, 'event' => $event, 'childEvent' => $childEvent]);
        return $pdf->stream();
    }

    /**
     * Shows the form for creating a new participation.
     *
     * @param Event $event
     *
     * @return \Illuminate\View\View
     */
    public function create(Event $event) {
        if (\Gate::denies('create', Participation::class)) {
            return redirect()->route('login');
        }

        $event->load('sportType');

        $selectedEventPart = Event::findByKey(request()->input(config('query.child_event')))->first();
        $selectedParticipationClass = ParticipationClass::find(request()->input(config('query.participation_class')));
        $coupons = Coupon::redeemable(Coupon::$types['participation'], $event)->get();

        return view('participation.create', compact('event', 'selectedEventPart', 'selectedParticipationClass', 'coupons'));
    }

    /**
     * Shows the form for editing the specified participation.
     *
     * @param Participation $participation
     *
     * @return \Illuminate\View\View
     */
    public function edit(Participation $participation) {
        if (\Gate::denies('update', $participation)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('participation.edit', compact('participation', 'isEditPage'));
    }

    /**
     * Creates a new participation with the data from the specified request and
     * stores the data in the database.
     *
     * @param  ParticipationCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ParticipationCreateRequest $request) {
        if (\Gate::denies('create', Participation::class)) {
            abort(403);
        }

        try {
            $participationClass = ParticipationClass::findOrFail($request->get('participation_class_id'));

            $participation = DB::transaction(function () use ($participationClass, $request) {
                $participation = Participation::create([
                    'participation_class_id' => $participationClass->getKey(),
                    'athlete_id'             => \Auth::id(),
                    'participation_state_id' => ParticipationState::whereLabel('registered')->first()->id,
                    'privacy'                => $request->get('privacy', 0),
                    'starter_number'         => \Auth::user()->athlete->starter_number
                ]);
                $customerId = \Auth::user()->activePaymentDetails->stripe_id;

                // Check if a coupon was used and calculate the discount
                $coupon = Coupon::redeemable(Coupon::$types['participation'], $participationClass->event)
                    ->where('code', $request->get('coupon'))->first();
                $price = $participationClass->getDiscountPrice($coupon);

                Charge::create([
                    'customer'    => $customerId,
                    'source'      => $request->get('source'),
                    'amount'      => $price,
                    "description" => "Charge for participation '" . $participation->getKey() . "' in event '"
                                     . $participationClass->event->title . "' at class '" . $participationClass->title
                                     . "'.",
                    "metadata"    => [
                        'payable_id' => $participation->getKey(),
                        'payable_type' => Participation::class,
                        'coupon_id' => $coupon ? $coupon->getKey() : null,
                        'fee' => calculateCCFee($price)
                    ],
                    'currency'    => 'eur'
                ]);

                return $participation;
            });

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
            return response()->json(['msg' => $e->getMessage()], 500);
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

        return response()->json($participation, empty($participation) ? 500 : 200);
    }

    /**
     * Updates the specified participation with the specified request data in the database.
     *
     * @param ParticipationCreateRequest $request
     * @param Participation              $participation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ParticipationCreateRequest $request, Participation $participation) {
        if (\Gate::denies('update', $participation)) {
            abort(403);
        }

        if ($participation->update($request->all())) {
            return response()->json($participation);
        }

        return response()->json($participation, 500);
    }

    /**
     * Removes the specified participation from the database.
     *
     * @param  \App\Models\Participation $participation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Participation $participation) {
        if (\Gate::denies('delete', $participation)) {
            abort(403);
        }

        if ($participation->delete()) {
            return response()->json($participation);
        }

        return response()->json($participation, 500);
    }

}

