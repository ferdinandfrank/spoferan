<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ParticipationClassCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new participationClass.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class ParticipationClassCreateRequest extends FormRequest {

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
			'description' => '',
			'entry_fee' => '',
			'club_participants_limit' => '',
			'privacy' => '',
			'multiple_starts' => '',
			'restr_limit' => '',
			'restr_birth_date_min' => '',
			'restr_birth_date_max' => '',
			'restr_gender' => '',
			'restr_label_id' => '',
			'restr_club_id' => '',
			'restr_country' => '',
			'restr_city' => '',
			'restr_postcode' => '',
			'start_date' => '',
			'end_date' => '',
			'register_date' => '',
			'unregister_date' => '',
			
        ];
    }
}
