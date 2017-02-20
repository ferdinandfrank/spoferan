<?php

namespace App\Models;

/**
 * HasCreator
 * -----------------------
 * Type of @link Model that has a creator as his owner.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasCreator {

    /**
     * Checks if an organizer owns/created this model instance.
     *
     * @param User|null $user
     *
     * @return bool
     */
    public function isCreator(User $user = null) {

        if (empty($user)) {
            if (\Auth::guest()) {
                return false;
            }
            $user = \Auth::user();
        }
        return $this[$this->getCreatorIdColumn()] == $user->id;
    }

    /**
     * Gets the foreign key column of the database table, that references the creator.
     *
     * @return string
     */
    protected function getCreatorIdColumn() {
        return 'organizer_id';
    }
}