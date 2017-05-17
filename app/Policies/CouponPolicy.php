<?php

namespace App\Policies;


use App\Models\Coupon;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * CouponPolicy
 * -----------------------
 * Handles the permissions on the coupon model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class CouponPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified coupon.
     *
     * @param  User  $user
     * @param  Coupon  $coupon
     *
     * @return boolean
     */
    public function view(User $user, Coupon $coupon) {
        return true;
    }

    /**
     * Determines whether the user can create coupons.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified coupon.
     *
     * @param  User  $user
     * @param  Coupon  $coupon
     *
     * @return boolean
     */
    public function update(User $user, Coupon $coupon) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified coupon.
     *
     * @param  User  $user
     * @param  Coupon  $coupon
     *
     * @return boolean
     */
    public function delete(User $user, Coupon $coupon) {
        return true;
    }
}
