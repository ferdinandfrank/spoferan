<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * UserPolicy
 * -----------------------
 * Handles the permissions on the user model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class UserPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified user.
     *
     * @param  User  $loggedUser
     * @param  User  $user
     *
     * @return boolean
     */
    public function view(User $loggedUser, User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified user.
     *
     * @param  User  $loggedUser
     * @param  User  $user
     *
     * @return boolean
     */
    public function update(User $loggedUser, User $user) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified user.
     *
     * @param  User  $loggedUser
     * @param  User  $user
     *
     * @return boolean
     */
    public function delete(User $loggedUser, User $user) {
        return true;
    }
}
