<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\VisitClass
 *
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $restr_limit
 * @property \Carbon\Carbon $register_date
 * @property \Carbon\Carbon $unregister_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Event $event
 * @property-read string $entry_fee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereRegisterDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereRestrLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereUnregisterDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\VisitClass whereUpdatedAt($value)
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
        'price',
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
            'price',
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
     * Check if the specified user or the currently logged user can visit at this class.
     *
     * @param User|null $user
     *
     * @return bool
     */
    public function canVisit(User $user = null) {
        return $this->getVisitRestriction($user)['error'] == false;
    }

    /**
     * Gets the visit restriction message for the specified user or the currently logged user, if he cannot
     * visit at this class.
     *
     * @param User|null $user
     *
     * @return array
     */
    public function getVisitRestriction(User $user = null) {

        if (empty($user)) {
            $user = Auth::user();
        }

        $now = Carbon::now();
        $result = ['error' => true, 'msg' => null];

        if ($this->register_date->gt($now)) {
            $result['msg'] = trans('validation.event.visit.restr_register_date', [
                'date' => $this->register_date->formatLocalized('%d %B %Y'),
                'time' => $this->register_date->formatLocalized('%H:%M')
            ]);

        } elseif ($this->unregister_date->lte($now)) {
            $result['msg'] = trans('validation.event.visit.restr_unregister_date', [
                'date' => $this->unregister_date->formatLocalized('%d %B %Y'),
                'time' => $this->unregister_date->formatLocalized('%H:%M')
            ]);

        } elseif (empty($user)) {
            $result['msg'] = trans('validation.event.visit.restr_registered');

        } elseif (!$user->isType(config('spoferan.user_type.athlete'))) {
            $result['msg'] = trans('validation.event.visit.restr_athlete');

        } elseif ($this->isVisitor($user->athlete)) {
            $result['msg'] = trans('validation.event.visit.already_registered');

        } elseif (!empty($this->restr_limit) && $this->restr_limit <= count($this->visitors)) {
            $result['msg'] = trans('validation.event.visit.restr_limit');

        } elseif ($this->isCreator($user)) {
            $result['msg'] = trans('validation.event.visit.restr_creator');

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

    /**
     * Scopes a query to only find visit classes which the specified athlete can visit.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $athlete
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanVisit($query, Athlete $athlete = null) {
        if (!$athlete) {
            if (!Auth::check() || !Auth::user()->isType(config('spoferan.user_type.athlete'))) {
                return $query;
            }

            $athlete = Auth::user()->athlete;
        }

        $now = Carbon::now();

        return $query->whereDate('register_date', '<', $now)
                     ->whereDate('unregister_date', '>', $now)
                     ->whereDoesntHave('visits', function ($subQuery) use ($athlete) {
                         $subQuery->where('athlete_id', $athlete->getKey());
                     })
                     ->where(function ($subQuery) {
                         $subQuery->whereNull('restr_limit')
                                  ->orWhereRaw('(select count(*) from `visits` where `visit_classes`.`id` = `visits`.`visit_class_id` and `visits`.`deleted_at` is null) < `visit_classes`.`restr_limit`');
                     });
    }
}
