<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * UserCreateRequest
 * -----------------------
 * Handles the rules for the request to create a new user.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Requests
 */
class UserCreateRequest extends FormRequest {

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
            'email'      => 'required|email|unique:users,email|max:' . config('validation.email.max'),
            'password'   => 'required|confirmed|max:' . config('validation.password.max') . '|min:'
                            . config('validation.password.min'),
            'avatar'     => '',
            'country'    => 'max:' . config('validation.country.max'),
            'postcode'   => 'max:' . config('validation.postcode.max'),
            'street'     => 'max:' . config('validation.street.max'),
            'phone'      => 'max:' . config('validation.phone.max'),
            'city'       => 'max:' . config('validation.city.max'),
            'title'      => 'max:' . config('validation.athlete.title.max'),
            'first_name' => 'required_if:user_type,' . config('spoferan.user_type.athlete') . '|max:'
                            . config('validation.athlete.first_name.max') . '|min:'
                            . config('validation.athlete.first_name.min'),
            'last_name'  => 'required_if:user_type,' . config('spoferan.user_type.athlete') . '|max:'
                            . config('validation.athlete.last_name.max') . '|min:'
                            . config('validation.athlete.first_name.min'),
            'gender'     => ['required_if:user_type,' . config('spoferan.user_type.athlete'), Rule::in(['m', 'w'])],
            'name'       => 'unique:organizers,name|required_if:user_type,' . config('spoferan.user_type.organizer'),
            'current_user_type'  => [
                'required',
                Rule::in(config('spoferan.user_type')),
            ],
        ];
    }
}
