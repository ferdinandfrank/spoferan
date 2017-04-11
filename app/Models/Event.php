<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends SlugModel {

    use SoftDeletes;
    use HasResourceRoutes;
    use HasCreator;
    use HasCoverImage;
    use HasStorage;
    use HasAddress;
    use Rateable;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_group_id',
        'parent_event_id',
        'title',
        'description_short',
        'description',
        'email',
        'phone',
        'cover',
        'sport_type_id',
        'start_date',
        'end_date',
        'country',
        'city',
        'postcode',
        'street'
    ];

    /**
     * The attributes that are searchable as the keys and their search operator
     * to apply as the value.
     * Valid values: 'LIKE', '<>', '=', '<', '>', '[relation_name]', '[class_name]'
     *
     * @var array
     */
    public $searchable = [
        'title' => 'LIKE',
        'description_short' => 'LIKE',
        'description' => 'LIKE',
        'sport_type' => [
            'sport_type_id' => SportType::class
        ],
        'country' => '=',
        'city' => 'LIKE',
        'postcode' => '=',
        'state' => '=',
        'date_interval_start' => [
            'start_date' => '>='
        ],
        'date_interval_end' => [
            'start_date' => '<='
        ],
    ];

    /**
     * The attributes that aren't mass assignable after the event has been finished.
     *
     * @var array
     */
    protected $guarded_after_finish = [
        'title',
        'sport_type_id',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'start_date',
        'end_date'
    ];

    /**
     * Gets the attribute name of the model, that shall be used for the slug of the model.
     *
     * @return string
     */
    public function getSlugName() {
        return $this->title;
    }

    /**
     * Gets the corresponding organizer instance, which is the creator of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer() {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    /**
     * Gets the sport type of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sportType() {
        return $this->belongsTo(SportType::class);
    }

    /**
     * Gets the event group of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventGroup() {
        return $this->belongsTo(EventGroup::class);
    }

    /**
     * Gets the participation classes of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participationClasses() {
        return $this->hasMany(ParticipationClass::class);
    }

    /**
     * Gets the labels of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function labels() {
        return $this->belongsToMany(Label::class, 'event_labels');
    }

    /**
     * Gets the participations of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function participations() {
        return $this->hasManyThrough(Participation::class, ParticipationClass::class);
    }

    /**
     * Gets the visit classes of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visitClasses() {
        return $this->hasMany(VisitClass::class);
    }

    /**
     * Gets the parent event of the event. If this property is not null, this event is handled as a
     * child / sub event of the parent event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentEvent() {
        return $this->belongsTo(Event::class, 'parent_event_id');
    }

    /**
     * Gets the child events of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childEvents() {
        return $this->hasMany(Event::class, 'parent_event_id');
    }

    /**
     * Gets the visits of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function visits() {
        return $this->hasManyThrough(Visit::class, VisitClass::class);
    }

    /**
     * Gets the check points of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkPoints() {
        return $this->hasMany(CheckPoint::class);
    }

    /**
     * Gets the start point of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function startCheckPoint() {
        $startPoint = $this->hasOne(CheckPoint::class)->wherePosition(1);

        if (empty($startPoint->getResults()) && count($this->checkPoints)) {
            $startPoint = $this->hasOne(CheckPoint::class);
        }

        return $startPoint;
    }

    /**
     * Gets the check points of the event which isn't the first or the last one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function middleCheckPoints() {
        return $this->hasMany(CheckPoint::class)
                    ->whereNotIn('position', [$this->startCheckPoint->position, $this->finishCheckPoint->position]);
    }

    /**
     * Gets the finish point of the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function finishCheckPoint() {
        return $this->hasOne(CheckPoint::class)->orderBy('position', 'desc')->limit(1);
    }

    /**
     * Check if the specified user or the currently logged user can participate in one of the event's participation
     * classes.
     *
     * @param User|null $user
     *
     * @return bool
     */
    public function canParticipate(User $user = null) {
        return empty($this->getParticipationRestriction($user));
    }

    /**
     * Checks if the specified user or the registered user can participate in one of the event's participation classes.
     *
     * @param User|null $user
     *
     * @return string
     */
    public function getParticipationRestriction(User $user = null) {
        if (empty($user)) {
            $user = Auth::user();
        }

        $now = Carbon::now();

        $result = null;

        if ($this->hasFinished()) {
            $result = 'restr_finished';

        } elseif ($this->isActive()) {
            $result = 'restr_active';

        } elseif ($this->getRegisterDate()->gt($now)) {
            $result = 'restr_register_date';

        } elseif ($this->getUnregisterDate()->lte($now)) {
            $result = 'restr_unregister_date';

        } elseif (empty($user)) {
            $result = 'restr_registered';

        } elseif (!$user->isType(config('spoferan.user_type.athlete'))) {
            $result = 'restr_athlete';

        } else {

            $availableClassCount = $this->participationClasses()->canParticipate($user->athlete)->count();;
            foreach ($this->childEvents as $event) {
                $availableClassCount += $event->participationClasses()->canParticipate($user->athlete)->count();
            }

            if ($availableClassCount <= 0) {
                $result = 'restr_participation_classes';
            }
        }

        return $result;
    }

    /**
     * Gets the register date. Will be calculated of its and its child events participation classes earliest register
     * date.
     *
     * @param Carbon $register_date
     *
     * @return null|Carbon
     */
    public function getRegisterDate(Carbon $register_date = null) {
        foreach ($this->participationClasses as $participationClass) {
            $class_date = $participationClass->register_date;
            if ($register_date == null || $class_date->lt($register_date)) {
                $register_date = $class_date;
            }
        }
        foreach ($this->childEvents as $childEvent) {
            return $childEvent->getRegisterDate($register_date);
        }

        return $register_date;
    }

    /**
     * Gets the unregister date. Will be calculated of its and its child events participation classes latest unregister
     * date.
     *
     * @param Carbon $unregister_date
     *
     * @return null|Carbon
     */
    public function getUnregisterDate(Carbon $unregister_date = null) {
        foreach ($this->participationClasses as $participationClass) {
            $class_date = $participationClass->unregister_date;
            if ($unregister_date == null || $class_date->gt($unregister_date)) {
                $unregister_date = $class_date;
            }
        }
        foreach ($this->childEvents as $childEvent) {
            return $childEvent->getUnregisterDate($unregister_date);
        }

        return $unregister_date;
    }

    /**
     * Gets the lowest price of the event's participation classes.
     *
     * @return float|null
     */
    public function getLowestPrice() {

        $lowestPrice = $this->participationClasses()->select('price')->min('price');
        foreach ($this->childEvents as $childEvent) {
            $lowestChildPrice = $childEvent->getLowestPrice();
            $lowestPrice = $lowestPrice && $lowestPrice < $lowestChildPrice ? $lowestPrice : $lowestChildPrice;
        }

        return $lowestPrice;
    }

    /**
     * Gets the total number of participants including child events.
     *
     * @return int|mixed
     */
    public function getTotalNumOfParticipants() {
        $participationsCount =
            property_exists($this, 'participations_count') ? $this->participations_count : count($this->participations);

        foreach ($this->childEvents as $childEvent) {
            $participationsCount += $childEvent->getTotalNumOfParticipants();
        }

        return $participationsCount;
    }

    /**
     * Gets the total number of visitors including child events.
     *
     * @return int|mixed
     */
    public function getTotalNumOfVisitors() {
        $visitsCount = property_exists($this, 'visits_count') ? $this->visits_count : count($this->visits);

        foreach ($this->childEvents as $childEvent) {
            $visitsCount += $childEvent->getTotalNumOfVisitors();
        }

        return $visitsCount;
    }

    /**
     * Set the events title.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTitleAttribute($value) {
        $this->attributes['title'] = ucfirst($value);
    }

    /**
     * Gets the full title of the event, i.e. if the event has a parent, its parents title is included in the title.
     *
     * @return string
     */
    public function getFullTitle() {
        if ($this->isChild()) {
            return $this->title . ' (' . $this->parentEvent->title . ')';
        }

        return $this->title;
    }

    /**
     * Gets the path to the event.
     *
     * @return string
     */
    public function getPath() {
        if (empty($this->parent_event_id)) {
            return route('events.show', $this);
        }

        return route('events.children.show', ['event' => $this->parentEvent, 'child' => $this]);
    }

    /**
     * Checks if an athlete is a participant of the event.
     *
     * @param Athlete $athlete
     *
     * @return bool
     */
    public function isParticipant(Athlete $athlete) {
        foreach ($this->participationClasses as $participationClass) {
            if ($participationClass->isParticipant($athlete)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if an athlete is a visitor of the event.
     *
     * @param Athlete $athlete
     *
     * @return bool
     */
    public function isVisitor(Athlete $athlete) {
        foreach ($this->visitClasses as $visitClass) {
            if ($visitClass->isVisitor($athlete)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if it is possible to register on the event.
     *
     * @return bool
     */
    public function isOpen() {
        $unregister_date = $this->getUnregisterDate();

        return !empty($unregister_date)
               && $unregister_date->gt(Carbon::now());
    }

    /**
     * Checks if the event is over.
     *
     * @return bool
     */
    public function hasFinished() {
        return !empty($this->end_date) && $this->end_date->lt(Carbon::now());
    }

    /**
     * Checks if the event start is in the past.
     *
     * @return bool
     */
    public function hasStarted() {
        return !empty($this->start_date) && $this->start_date->lt(Carbon::now());
    }

    /**
     * Checks if the event is running right now.
     *
     * @return bool
     */
    public function isActive() {
        return $this->hasStarted() && !$this->hasFinished();
    }

    /**
     * Checks if the event is a main event.
     *
     * @return bool
     */
    public function isMain() {
        return empty($this->parent_event_id);
    }

    /**
     * Checks if the event is a child event of an other.
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isChild(Event $event = null) {
        if (!empty($event)) {
            return $this->parent_event_id == $event->id;
        }

        return !$this->isMain();
    }

    /**
     * Checks if the event is a parent event of an other.
     *
     * @return bool
     */
    public function isParent() {
        return count($this->childEvents);
    }

    /**
     * Publishes the event, so athletes can participate.
     */
    public function publish() {
        $this->published = 1;
        $this->save();
    }

    /**
     * Protects the event, so athletes can not participate anymore.
     */
    public function protect() {
        $this->published = 0;
        $this->save();
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
        if ($this->hasFinished() && in_array($key, $this->guarded_after_finish)) {
            return false;
        }

        return parent::isFillable($key);
    }

    /**
     * Scopes a query to only include  published events.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished($query) {
        return $query->where('published', true);
    }

    /**
     * Scopes a query to only include open events where an athlete could participate.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOpen($query) {
        return $query->whereDate('start_date', '>=', Carbon::now())->published();
    }

    /**
     * Scopes a query to only include main events.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeMain($query) {
        return $query->where('parent_event_id', null);
    }


}


