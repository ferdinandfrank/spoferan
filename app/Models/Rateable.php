<?php

namespace App\Models;

use DB;

/**
 * Rateable
 * -----------------------
 * Type of @link Model that can be rated by an user.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */

trait Rateable {

    /**
     * Gets the raters of the rateable object.
     *
     * @return Athlete
     */
    public function raters() {
        return $this->belongsToMany($this->getRaterClass(), $this->getRateableTable(), $this->getForeignKey(), $this->getRaterKeyName())
            ->withPivot('rating', 'description', 'privacy')
            ->withTimestamps();
    }

    /**
     * Gets the average rating of this model.
     *
     * @return mixed
     */
    public function getRating() {
        return DB::table($this->getRateableTable())->where($this->getForeignKey(), $this->getKey())->avg('rating');
    }

    /**
     * Gets the rating for the specific user, if he's a rater of the rateable object.
     *
     * @param BaseModel|int|string $user
     * @return mixed|null
     */
    public function getRatingFor($user) {
        if ($user instanceof BaseModel) {
            $user = $user->getKey();
        }

        $rater = $this->raters()->where($this->getRaterKeyName(), $user)->first();
        if (empty($rater)) {
            return null;
        }

        return $rater->pivot;
    }

    /**
     * Gets the column name of the rater.
     *
     * @return string
     */
    public function getRaterKeyName() {
        return 'athlete_id';
    }

    /**
     * Gets the class name of the rater.
     *
     * @return string
     */
    public function getRaterClass() {
        return Athlete::class;
    }

    /**
     * Checks if an user is a rater of the rateable object.
     *
     * @param BaseModel|int|string $user
     *
     * @return bool
     */
    public function hasRater($user) {
        if ($user instanceof BaseModel) {
            $user = $user->getKey();
        }

        return $this->raters()->where($this->getRaterKeyName(), $user)->count() > 0;
    }

    /**
     * Gets the route path to show the edit form to update the rating made by the current user for the rateable object in the database.
     *
     * @return string
     */
    public function getEditRatingPath() {
        return $this->buildRatingPath('edit');
    }

    /**
     * Gets the route path to store a new rating made by the current user for the rateable object in the database.
     *
     * @return string
     */
    public function getStoreRatingPath() {
        return $this->buildRatingPath('store');
    }

    /**
     * Gets the route path to update the rating made by the current user for the rateable object in the database.
     *
     * @return string
     */
    public function getUpdateRatingPath() {
        return $this->buildRatingPath('update');
    }

    /**
     * Gets the route path to destroy the rating made by the current user for the rateable object in the database.
     *
     * @return string
     */
    public function getDestroyRatingPath() {
        return $this->buildRatingPath('destroy');
    }

    /**
     * Builds a route path for the ratings of the rateable object and for the specific action.
     *
     * @param string $action
     * @return string
     */
    private function buildRatingPath(string $action) {
        return route($this->getTable() . '.ratings.' . $action, $this);
    }

    /**
     * Gets the table name of the models ratings.
     *
     * @return string
     */
    protected function getRateableTable() {
        return snake_case(class_basename($this)) . '_ratings';
    }

}