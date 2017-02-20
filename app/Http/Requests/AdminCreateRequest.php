<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * AdminCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new admin.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class AdminCreateRequest extends FormRequest {

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
            'name' => ''
        ];
    }
}
