<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Event

 *
*@property int $id
 * @property int $organizer_id
 * @property int $event_group_id
 * @property int $parent_event_id
 * @property string $title
 * @property string                                                                         $slug
 * @property string                                                                         $description_short
 * @property string                                                                         $description
 * @property string                                                                         $email
 * @property string                                                                         $phone
 * @property string                                                                         $cover
 * @property int                                                                            $sport_type_id
 * @property bool                                                                           $published
 * @property \Carbon\Carbon                                                                 $start_date
 * @property \Carbon\Carbon                                                                 $end_date
 * @property \Carbon\Carbon                                                                 $created_at
 * @property \Carbon\Carbon                                                                 $updated_at
 * @property \Carbon\Carbon                                                                 $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CheckPoint[]         $checkPoints
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[]              $childEvents
 * @property-read \App\Models\Organizer                                                     $organizer
 * @property-read \App\Models\Event                                                         $parentEvent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParticipationClass[] $participationClasses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participation[]      $participations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Athlete[]            $raters
 * @property-read \App\Models\SportType $sportType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VisitClass[] $visitClasses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event byDistance($latitude, $longitude, $distance)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event byLocation($country, $city, $postcode)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event byRating($rating)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event byStatus($status)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event onlyMain()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event onlyPublished()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereDescriptionShort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereEventGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereOrganizerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereParentEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event wherePublished($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereSportTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Event withStatistics()
 * @mixin \Eloquent
 */
class Event extends SlugModel {

    use SoftDeletes;
    use HasResourceRoutes;
    use HasCreator;
    use HasCoverImage;
    use HasStorage;
    use Rateable;

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
            'end_date'
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
        return $this->belongsTo(Organizer::class);
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
     * Gets the participation classes of the event.

     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participationClasses() {
        return $this->hasMany(ParticipationClass::class);
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
     * Gets the track points of the event.

     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkPoints() {
        return $this->hasMany(CheckPoint::class);
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
     * Gets the most similar events for the event.
     *
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSimilarEvents(int $limit = null) {
        return (new EventQuery())->onlySimilar($this, $limit)->get();
    }

    /**
     * Gets the sibling events of the event.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSiblingEvents() {
        return (new EventQuery())->onlySiblings($this)->get();
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
     * Checks if any other event with the same parent event exists.
     *
     * @return bool
     */
    public function hasSiblings() {
        return $this->isChild() && (new EventQuery())->onlySiblings($this)->get()->count() > 0;
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
     * Scopes a query with including only published events.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOnlyPublished($query) {
        return (new EventQuery($query))->onlyPublished();
    }

    /**
     * Scopes a query depending on the distance of its track points to a given distance.
     *
     * @param Builder $query
     * @param double  $latitude
     * @param double  $longitude
     * @param int     $distance
     *
     * @return Builder
     */
    public function scopeByDistance($query, $latitude, $longitude, $distance) {
        return (new EventQuery($query))->byDistance($latitude, $longitude, $distance);
    }

    /**
     * Scopes a query including the stats for the events.
     *
     * @param $query
     *
     * @return Builder
     */
    public function scopeWithStatistics($query) {
        return (new EventQuery($query))->withStatistics();
    }

    /**
     * Scopes a query to events, that have a minimum average rating.
     *
     * @param $query
     * @param $rating
     *
     * @return Builder
     */
    public function scopeByRating($query, $rating) {
        return (new EventQuery($query))->byRating($rating);
    }

    /**
     * Scopes a query to only include events of a given status.
     *
     * @param Builder $query
     * @param string  $status
     *
     * @return Builder
     */
    public function scopeByStatus($query, $status) {
        return (new EventQuery($query))->byStatus($status);
    }

    /**
     * Scopes a query to only include main events.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOnlyMain($query) {
        return (new EventQuery($query))->onlyMain();
    }

    /**
     * Scopes a query to search for an address.
     *
     * @param string   $country
     * @param string   $city
     * @param          $postcode
     * @param  Builder $query
     *
     * @return Builder
     */
    public function scopeByLocation(Builder $query, string $country, string $city, $postcode) {
        return (new EventQuery($query))->byLocation($country, $city, $postcode);
    }

}


