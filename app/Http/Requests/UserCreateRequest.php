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
            'email'      => 'required|email|unique:users,email|max:' . config('validation.user.email.max'),
            'password'   => 'required|confirmed|max:' . config('validation.user.password.max') . '|min:'
                            . config('validation.user.password.min'),
            'avatar'     => '',
            'country'    => 'max:' . config('validation.user.country.max'),
            'postcode'   => 'max:' . config('validation.user.postcode.max'),
            'street'     => 'max:' . config('validation.user.street.max'),
            'phone'      => 'max:' . config('validation.user.phone.max'),
            'city'       => 'max:' . config('validation.user.city.max'),
            'first_name' => 'required_if:user_type,' . config('starmee.user_type.athlete'),
            'last_name'  => 'required_if:user_type,' . config('starmee.user_type.athlete'),
            'gender'     => ['required_if:user_type,' . config('starmee.user_type.athlete'), Rule::in(['m', 'w'])],
            'name'       => 'unique:organizers,name|required_if:user_type,' . config('starmee.user_type.organizer'),
            'user_type'  => [
                'required',
                Rule::in(config('starmee.user_type')),
            ],
        ];
    }
}
