<?php

namespace App\Models;


/**
 * App\Models\TrackPoint
 *
 * @property-read \App\Models\Event $event
 * @mixin \Eloquent
 */
class CheckPoint extends BaseModel {

    use HasResourceRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'check_points';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude',
        'longitude',
        'position',
        'title',
        'description',
        'street',
        'country',
        'postcode',
        'city'
    ];

    /**
     * The parents in the route paths as a string array to build the resource routes of the model.
     * Shall be the same as the class name of the 'belongsTo' relationship between the parent and this model.
     *
     * @return array
     */
    protected static function getRouteParents() {
        return ['event'];
    }

    /**
     * Gets the event of the track point.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Gets the string representation of the track points address.
     *
     * @return string
     */
    public function toAddressString() {
        return $this->street . ', ' . $this->city . ' ' . $this->postcode . ', ' . $this->country;
    }
}
