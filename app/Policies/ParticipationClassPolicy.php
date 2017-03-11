<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ParticipationClass;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * ParticipationClassPolicy
 * -----------------------
 * Handles the permissions on the participationClass model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class ParticipationClassPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified participationClass.
     *
     * @param  User  $user
     * @param  ParticipationClass  $participationClass
     *
     * @return boolean
     */
    public function view(User $user, ParticipationClass $participationClass) {
        return true;
    }

    /**
     * Determines whether the user can create participationClasses.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified participationClass.
     *
     * @param  User  $user
     * @param  ParticipationClass  $participationClass
     *
     * @return boolean
     */
    public function update(User $user, ParticipationClass $participationClass) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified participationClass.
     *
     * @param  User  $user
     * @param  ParticipationClass  $participationClass
     *
     * @return boolean
     */
    public function delete(User $user, ParticipationClass $participationClass) {
        return true;
    }
}
