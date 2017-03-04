<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Participation;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * ParticipationPolicy
 * -----------------------
 * Handles the permissions on the participation model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class ParticipationPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified participation.
     *
     * @param  User  $user
     * @param  Participation  $participation
     *
     * @return boolean
     */
    public function view(User $user, Participation $participation) {
        return true;
    }

    /**
     * Determines whether the user can create participations.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified participation.
     *
     * @param  User  $user
     * @param  Participation  $participation
     *
     * @return boolean
     */
    public function update(User $user, Participation $participation) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified participation.
     *
     * @param  User  $user
     * @param  Participation  $participation
     *
     * @return boolean
     */
    public function delete(User $user, Participation $participation) {
        return true;
    }
}
