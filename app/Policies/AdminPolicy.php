<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * AdminPolicy
 * -----------------------
 * Handles the permissions on the admin model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class AdminPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified admin.
     *
     * @param  User  $user
     * @param  Admin  $admin
     *
     * @return boolean
     */
    public function view(User $user, Admin $admin) {
        return true;
    }

    /**
     * Determines whether the user can create admins.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified admin.
     *
     * @param  User  $user
     * @param  Admin  $admin
     *
     * @return boolean
     */
    public function update(User $user, Admin $admin) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified admin.
     *
     * @param  User  $user
     * @param  Admin  $admin
     *
     * @return boolean
     */
    public function delete(User $user, Admin $admin) {
        return true;
    }
}
