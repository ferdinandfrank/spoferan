<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\VisitClass
 *
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Visit[] $visits
 * @mixin \Eloquent
 */
class VisitClass extends BaseModel {

    use HasResourceRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visit_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'entry_fee',
        'restr_limit',
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
            'entry_fee',
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
        'start_date',
        'end_date',
        'register_date',
        'unregister_date',
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
     * Gets the event of the visit class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Gets the visits of the visit class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits() {
        return $this->hasMany(Visit::class);
    }

    /**
     * Checks if an athlete is a visitor of the class.
     *
     * @param Athlete $athlete
     *
     * @return bool
     */
    public function isVisitor(Athlete $athlete) {
        return $this->visits()->where('athlete_id', $athlete->getKey())->count() > 0;
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
     * Checks if an registration as a visitor in the visit class is possible.
     * TODO: Extract to request validation class
     *
     * @param User|null $user
     *
     * @return array
     */
    public function isVisitPossible(User $user = null) {

        if (empty($user)) {
            $user = Auth::user();
        }

        $result = ['error' => true, 'msg' => null];

        if (empty($user) || !$user->isType(\Config::get('user_type.athlete'))) {
            $result['msg'] = trans('validation.event.restr_registered');

        } elseif ($this->isVisitor($user->athlete)) {
            $result['msg'] = trans('validation.event.visit.already_registered');

        } elseif (!empty($this->restr_limit) && $this->restr_limit <= count($this->visitors)) {
            $result['msg'] = trans('validation.event.visit.restr_limit');

        } elseif ($this->isCreator($user)) {
            $result['msg'] = trans('validation.event.visit.restr_creator');

        } elseif ($this->status->label == 'register_paused') {
            $result['msg'] = trans('validation.event.participate.restr_registration_paused');
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
