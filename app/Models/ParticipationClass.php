<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

/**
 * App\Models\ParticipationClass
 *
 * @property int                                                                       $id
 * @property int                                                                       $event_id
 * @property string                                                                    $title
 * @property string                                                                    $description
 * @property float                                                                     $entry_fee
 * @property bool                                                                      $privacy
 * @property \Carbon\Carbon                                                            $start_date
 * @property \Carbon\Carbon                                                            $end_date
 * @property \Carbon\Carbon                                                            $register_date
 * @property \Carbon\Carbon                                                            $unregister_date
 * @property int                                                                       $restr_limit
 * @property \Carbon\Carbon                                                            $restr_birth_date_min
 * @property \Carbon\Carbon                                                            $restr_birth_date_max
 * @property string                                                                    $restr_gender
 * @property string                                                                    $restr_country
 * @property string                                                                    $restr_city
 * @property int                                                                       $restr_postcode
 * @property \Carbon\Carbon                                                            $created_at
 * @property \Carbon\Carbon                                                            $updated_at
 * @property-read \App\Models\Event                                                    $event
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participation[] $participations
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereEntryFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRegisterDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrBirthDateMax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrBirthDateMin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereRestrPostcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereUnregisterDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationClass whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ParticipationClass extends BaseModel {

    use HasResourceRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participation_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'club_participants_limit',
        'privacy',
        'multiple_starts',
        'restr_limit',
        'restr_birth_date_min',
        'restr_birth_date_max',
        'restr_gender',
        'restr_label_id',
        'restr_club_id',
        'restr_country',
        'restr_city',
        'restr_postcode',
        'start_date',
        'end_date',
        'register_date',
        'unregister_date',
    ];

    /**
     * The attributes that aren't mass assignable after the even has been finished.
     *
     * @var array
     */
    protected $guarded_after_finish
        = [
            'title',
            'price',
            'start_date',
            'end_date',
            'register_date',
            'unregister_date',
        ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'restr_birth_date_min',
        'restr_birth_date_max',
        'start_date',
        'end_date',
        'register_date',
        'unregister_date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['entry_fee'];

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
     * Gets the amount of the participation class as a decimal amount.
     *
     * @return string
     */
    public function getEntryFeeAttribute() {
        return translateCents($this->attributes['price']);
    }

    /**
     * Gets the event of the participation class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Gets the participations of the participation class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participations() {
        return $this->hasMany(Participation::class);
    }

    /**
     * Checks if an athlete is a participant of the class.
     *
     * @param Athlete $athlete
     *
     * @return bool
     */
    public function isParticipant(Athlete $athlete) {
        return $this->participations()->where('athlete_id', $athlete->getKey())->count() > 0;
    }

    /**
     * Checks if an user is the creator of the class.
     *
     * @param User $user
     *
     * @return bool
     */
    public function isCreator(User $user) {
        return $this->event->isCreator($user);
    }

    /**
     * Check if the specified user or the currently logged user can participate at this class.
     *
     * @param User|null $user
     *
     * @return bool
     */
    public function canParticipate(User $user = null) {
        return $this->getParticipationRestriction($user)['error'] == false;
    }

    /**
     * Gets the participation restriction message for the specified user or the currently logged user, if he cannot
     * participate at this class.
     *
     * @param User|null $user
     *
     * @return array
     */
    public function getParticipationRestriction(User $user = null) {

        if (empty($user)) {
            $user = Auth::user();
        }

        $result = ['error' => true, 'msg' => null];

        if (empty($user) || !$user->isType(config('starmee.user_type.athlete'))) {
            $result['msg'] = trans('validation.event.participate.restr_registered');

        } elseif ($this->isParticipant($user->athlete)) {
            $result['msg'] = trans('validation.event.participate.already_registered');

        } elseif (!empty($this->restr_limit) && $this->restr_limit <= count($this->participations)) {
            $result['msg'] = trans('validation.event.participate.restr_limit');

        } elseif (!empty($this->restr_birth_date_min) && $this->restr_birth_date_min < $user->athlete->birth_date) {
            $result['msg'] = trans('validation.event.participate.restr_birth_date_min');

        } elseif (!empty($this->restr_birth_date_max) && $this->restr_birth_date_max > $user->athlete->birth_date) {
            $result['msg'] = trans('validation.event.participate.restr_birth_date_max');

        } elseif (!empty($this->restr_gender) && $this->restr_gender != $user->athlete->gender) {
            if ($this->restr_gender == 'w') {
                $result['msg'] = trans('validation.event.participate.restr_gender_female');
            } else {
                $result['msg'] = trans('validation.event.participate.restr_gender_male');
            }

        } elseif (!empty($this->restr_country) && $this->restr_country != $user->country
        ) {
            $result['msg'] = trans('validation.event.participate.restr_country', ['country' => $this->restr_country]);

        } elseif (!empty($this->restr_city) && !empty($this->restr_postcode) && $this->restr_city != $user->city
                  && $this->restr_postcode != $user->postcode
        ) {
            $result['msg'] = trans('validation.event.participate.restr_city', ['city' => $this->restr_city]);

        } elseif ($this->isCreator($user)) {
            $result['msg'] = trans('validation.event.participate.restr_creator');

        } else {
            $result['error'] = false;
        }

        return $result;
    }

    /**
     * Determine if the given attribute may be mass assigned.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function isFillable($key) {

        // Check if there are guarded inputs, after the event has finished.
        // If no event exists, this method is called on the participation class creation,
        // which is only possible if the event hasn't started!
        if ($this->event && $this->event->hasFinished() && in_array($key, $this->guarded_after_finish)) {
            return false;
        }

        return parent::isFillable($key);
    }

}

