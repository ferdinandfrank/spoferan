<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Creates a new controller instance.
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Gets the password reset validation rules.
     *
     * @return array
     */
    protected function rules() {
        return [
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|confirmed|max:' . config('validation.password.max') . '|min:'
                          . config('validation.password.min'),
        ];
    }

    /**
     * Gets the response for a successful password reset.
     *
     * @param $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response) {
        return response()->json($response);
    }

    /**
     * Gets the response for a failed password reset.
     *
     * @param Request $request
     * @param         $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response) {
        return response()->json(['email' => trans($response)], 400);
    }
}
