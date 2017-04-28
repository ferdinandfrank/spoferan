<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * ResetPasswordController
 * -----------------------
 * This controller is responsible for handling password reset requests
 * and uses a simple trait to include this behavior. You're free to
 * explore this trait and override any methods you wish to tweak.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller {

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

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

    /**
     * Resets the given user's password and logs in the user.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string                                      $password
     */
    protected function resetPassword($user, $password) {
        $user->forceFill([
            'password'       => $password,
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }
}
