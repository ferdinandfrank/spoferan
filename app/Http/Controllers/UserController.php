<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmationMail;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use Auth;
use DB;

/**
 * UserController
 * -----------------------
 * Controller to handle the user routes.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Http\Controllers
 */
class UserController extends Controller {

    /**
     * Displays a listing of all the users.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        return view('user.index');
    }

    /**
     * Displays the specified user.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user) {
        if (\Gate::denies('view', $user)) {
            abort(404, 'Page not found.');
        }

        return view('user.show', compact('user'));
    }

    /**
     * Shows the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('auth.register');
    }

    /**
     * Shows the form for editing the specified user.
     *
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user) {
        if (\Gate::denies('update', $user)) {
            abort(404, 'Page not found.');
        }

        $isEditPage = true;

        return view('user.edit', compact('user', 'isEditPage'));
    }

    /**
     * Creates a new user with the data from the specified request and
     * stores the data in the database.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request) {
        $user = DB::transaction(function () use ($request) {
            $user = new User($request->all());
            $user->confirmation_token = bin2hex(random_bytes(10));
            $user->confirmed = false;
            $user->verified = false;
            $user->save();
            if ($user) {
                $userType = null;
                if ($user->isType(config('spoferan.user_type.athlete'))) {
                    $userType = $user->athlete()->create($request->all());
                } else {
                    $userType = $user->organizer()->create($request->all());
                }

                \Mail::to($user)->send(new EmailConfirmationMail($user));
                return !empty($userType) ? $user : false;
            }
            return false;
        });

        return response()->json($user, $user ? 200 : 500);
    }

    /**
     * Updates the specified user with the specified request data in the database.
     *
     * @param UserCreateRequest $request
     * @param User              $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserCreateRequest $request, User $user) {
        if (\Gate::denies('update', $user)) {
            abort(403);
        }

        if ($user->update($request->all())) {
            return response()->json($user);
        }

        return response()->json($user, 500);
    }

    /**
     * Removes the specified user from the database.
     *
     * @param  \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user) {
        if (\Gate::denies('delete', $user)) {
            abort(403);
        }

        if ($user->delete()) {
            return response()->json($user);
        }

        return response()->json($user, 500);
    }

}

