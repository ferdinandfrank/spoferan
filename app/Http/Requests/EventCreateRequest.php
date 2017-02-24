<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * EventCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new event.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class EventCreateRequest extends FormRequest {

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
            'event_group_id' => '',
			'parent_event_id' => '',
			'title' => '',
			'description_short' => '',
			'description' => '',
			'email' => '',
			'phone' => '',
			'cover' => '',
			'sport_type_id' => '',
			'start_date' => '',
			'end_date' => '',
			'country' => '',
			'city' => '',
			'postcode' => '',
			'street' => '',
			
        ];
    }
}
