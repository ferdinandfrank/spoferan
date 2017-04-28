<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * LoginController
 * -----------------------
 * This controller handles authenticating users for the application and
 * redirecting them to your home screen. The controller uses a trait
 * to conveniently provide its functionality to your applications.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller {

    use AuthenticatesUsers;

    /**
     * Creates a new controller instance.
     */
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Shows the application's login form.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request) {
        $this->confirmUser($request);

        return view('auth.login');
    }

    /**
     * Checks if the necessary params exists in the current request to confirm a user
     * and executes the confirmation if the params are valid.
     *
     * @param Request $request
     */
    private function confirmUser(Request $request) {
        $token = $request->input('token');
        $id = $request->input('id');
        if ($id && $token) {
            $user = User::find($id);

            // Check if the confirmation token is valid and the user has not be confirmed
            if ($user && $user->confirmation_token == $token && !$user->confirmed) {
                $user->confirm();
                $request->session()->flash('success', trans('alert.account_confirmed'));
            }
        }
    }

    /**
     * Handles a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $this->validateLogin($request);

        // Check if the user is still unconfirmed. If so, resend the confirmation mail.
        $email = $request->get('email');
        $unconfirmedUser = User::where('email', $email)->where('confirmed', false)->first();
        if ($unconfirmedUser) {
            $unconfirmedUser->sendConfirmationMail();

            return response()->json([
                'msg' => trans('error.unconfirmed', ['email' => $email])
            ], 403);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
    }

    /**
     * Handles the action when the user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user) {
        return response()->json($user);
    }

    /**
     * Logs the user out of the application.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return response()->json(true);
    }

    /**
     * Gets the failed login response instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse() {
        return response()->json([
            'msg' => [trans('validation.auth.failed')]
        ], 403);
    }

    /**
     * Redirects the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = trans('error.throttle', ['seconds' => $seconds]);
        $errors = [config('spoferan.server_error_key') => $message];

        if ($request->expectsJson()) {
            return response()->json($errors, 423);
        }

        return redirect()->back()
                         ->withInput($request->only($this->username(), 'remember'))
                         ->withErrors($errors);
    }
}
