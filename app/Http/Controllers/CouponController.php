<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Http\Requests\CouponCreateRequest;

/**
 * CouponController
 * -----------------------
 * Controller to handle the coupon routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class CouponController extends Controller {

    /**
     * Displays a listing of all the coupons.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('coupon.index');
    }

    /**
     * Displays the specified coupon.
     *
     * @param Coupon $coupon
     *
     * @return \Illuminate\View\View
     */
    public function show(Coupon $coupon) {
        if (\Gate::denies('view', $coupon)) {
            abort(404, 'Page not found.');
        }

        return view('coupon.show', compact('coupon'));
    }

    /**
     * Shows the form for creating a new coupon.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        if (\Gate::denies('create', Coupon::class)) {
            abort(404, 'Page not found.');
        }

        $coupon = new Coupon();
        $isEditPage = false;

        return view('coupon.edit', compact('coupon', 'isEditPage'));
    }

    /**
     * Shows the form for editing the specified coupon.
     *
     * @param Coupon $coupon
     *
     * @return \Illuminate\View\View
     */
    public function edit(Coupon $coupon) {
        if (\Gate::denies('update', $coupon)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('coupon.edit', compact('coupon', 'isEditPage'));
    }

    /**
     * Creates a new coupon with the data from the specified request and
     * stores the data in the database.
     *
     * @param  CouponCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CouponCreateRequest $request) {
        if (\Gate::denies('create', Coupon::class)) {
            abort(403);
        }

        $coupon = Coupon::create($request->all());

        return response()->json($coupon, empty($coupon) ? 500 : 200);
    }

    /**
     * Updates the specified coupon with the specified request data in the database.
     *
     * @param CouponCreateRequest $request
     * @param Coupon $coupon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CouponCreateRequest $request, Coupon $coupon) {
        if (\Gate::denies('update', $coupon)) {
            abort(403);
        }

        if ($coupon->update($request->all())) {
            return response()->json($coupon);
        }

        return response()->json($coupon, 500);
    }

    /**
     * Removes the specified coupon from the database.
     *
     * @param  \App\Models\Coupon  $coupon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Coupon $coupon) {
        if (\Gate::denies('delete', $coupon)) {
            abort(403);
        }

        if ($coupon->delete()) {
            return response()->json($coupon);
        }

        return response()->json($coupon, 500);
    }

}

