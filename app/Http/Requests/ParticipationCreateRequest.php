<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ParticipationCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new participation.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class ParticipationCreateRequest extends FormRequest {

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
            'participation_class_id' => '',
			'description' => '',
			'privacy' => '',
			'rank' => '',
			'time' => '',
			'starter_number' => '',
			'participation_state_id' => '',
			
        ];
    }
}
