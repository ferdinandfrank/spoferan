<?php

namespace App\Models;

/**
 * HasAnonymousAthletes
 * -----------------------
 * Type of @link BaseModel that has an athlete relation, that has a privacy column in the database.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait HasAnonymousAthletes {

    /**
     * Gets the athlete of the model.
     *
     * @return Athlete
     */
    public function athlete() {
        return $this->belongsTo(Athlete::class, 'athlete_id');
    }

    /**
     * Gets the name of the model's athlete in an html format.
     * Will be the anonymous name representation, if the privacy is set to true.
     *
     * @param $forcePrivacy
     * @return string
     */
    public function getAthletePresentationName($forcePrivacy = false) {
        if ($forcePrivacy || $this->privacy) {
            return '<em>' . $this->athlete->getAnonymousName() . '</em>';
        }

        return '<a href="#" class="link">' . $this->athlete->getFullName() . '</a>';
    }
}