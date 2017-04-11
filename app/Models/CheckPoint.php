<?php

namespace App\Models;

/**
 * App\Models\CheckPoint
 *
 * @property int $id
 * @property int $event_id
 * @property int $position
 * @property string $title
 * @property float $latitude
 * @property float $longitude
 * @property string $country
 * @property string $postcode
 * @property string $city
 * @property string $street
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint wherePostcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CheckPoint whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CheckPoint extends BaseModel {

    use HasResourceRoutes;
    use HasAddress;

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
     * Gets the latitude and longitude coordinates of the checkpoint as json.
     *
     * @return string
     */
    public function getLatLng() {
        return "{lat: $this->latitude, lng: $this->longitude}";
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
