<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmationMail;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use DB;
use Illuminate\Support\Facades\App;

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

            // Create the user with the request data
            $user = new User($request->all());

            // Let the user confirm his email address if the environment is local or production
            if (App::environment('testing')) {
                $user->confirmed = true;
            } else {
                $user->setConfirmationToken();
            }

            if ($user->save()) {
                $userType = null;
                if ($user->isType(config('spoferan.user_type.athlete'))) {
                    $userType = $user->athlete()->create($request->all());
                } else {
                    $userType = $user->organizer()->create($request->all());
                }

                if ($userType) {

                    // Only send confirmation email, if the user is not yet confirmed, i.e. the app environment is
                    // set as 'testing'
                    if (!$user->confirmed) {
                        \Mail::to($user)->queue((new UserConfirmationMail($user))->onQueue('emails'));
                    }

                    return $user;
                }
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

