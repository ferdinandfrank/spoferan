<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Creates a new controller instance.
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Gets the response for a successful password reset link.
     *
     * @param $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response) {
        return response()->json($response);
    }

    /**
     * Gets the response for a failed password reset link.
     *
     * @param Request $request
     * @param         $response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response) {
        return response()->json(['email' => trans($response)], 400);
    }
}
