<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * AthleteCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new athlete.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class AthleteCreateRequest extends FormRequest {

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
            'title' => '',
			'first_name' => '',
			'last_name' => '',
			'birth_date' => '',
			'gender' => '',
			'sport_type_id' => '',
			
        ];
    }
}
