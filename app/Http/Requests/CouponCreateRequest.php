<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CouponCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new coupon.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class CouponCreateRequest extends FormRequest {

    /**
     * Determines if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Gets the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code' => '',
			'creator_id' => '',
			'amount_off' => '',
			'percent_off' => '',
			'redeem_start' => '',
			'redeem_end' => '',
			'type' => '',
			'max_redemptions' => '',
			'times_redeemed' => '',
			'valid' => '',
			
        ];
    }
}
