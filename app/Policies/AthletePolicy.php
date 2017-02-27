<?php

namespace App\Policies;

use ModelNamespaceUser;
use App\Models\Athlete;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * AthletePolicy
 * -----------------------
 * Handles the permissions on the athlete model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class AthletePolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified athlete.
     *
     * @param  User  $user
     * @param  Athlete  $athlete
     *
     * @return boolean
     */
    public function view(User $user, Athlete $athlete) {
        return true;
    }

    /**
     * Determines whether the user can create athletes.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified athlete.
     *
     * @param  User  $user
     * @param  Athlete  $athlete
     *
     * @return boolean
     */
    public function update(User $user, Athlete $athlete) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified athlete.
     *
     * @param  User  $user
     * @param  Athlete  $athlete
     *
     * @return boolean
     */
    public function delete(User $user, Athlete $athlete) {
        return true;
    }
}
