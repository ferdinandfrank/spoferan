<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * EventPolicy
 * -----------------------
 * Handles the permissions on the event model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Policies
 */
class EventPolicy {

    use HandlesAuthorization;

    /**
     * Determines whether the user can view the specified event.
     *
     * @param  User  $user
     * @param  Event  $event
     *
     * @return boolean
     */
    public function view(User $user, Event $event) {
        return true;
    }

    /**
     * Determines whether the user can create events.
     *
     * @param  User  $user
     * @return boolean
     */
    public function create(User $user) {
        return true;
    }

    /**
     * Determines whether the user can update the specified event.
     *
     * @param  User  $user
     * @param  Event  $event
     *
     * @return boolean
     */
    public function update(User $user, Event $event) {
        return true;
    }

    /**
     * Determines whether the user can delete the specified event.
     *
     * @param  User  $user
     * @param  Event  $event
     *
     * @return boolean
     */
    public function delete(User $user, Event $event) {
        return true;
    }

    /**
     * Determines whether the user can participate in the specified event.
     *
     * @param  User  $user
     * @param  Event  $event
     *
     * @return boolean
     */
    public function participate(User $user, Event $event) {
        return $user->isType(config('starmee.user_type.athlete'));
    }

    /**
     * Determines whether the user can visit the specified event.
     *
     * @param  User  $user
     * @param  Event  $event
     *
     * @return boolean
     */
    public function visit(User $user, Event $event) {
        return $user->isType(config('starmee.user_type.athlete'));
    }
}
