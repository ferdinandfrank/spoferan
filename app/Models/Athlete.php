<?php

namespace App\Models;
use App\Events\AthleteCreated;


/**
 * App\Models\Athlete
 *
 * @property int $user_id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $slug
 * @property \Carbon\Carbon $birth_date
 * @property string $gender
 * @property int $sport_type_id
 * @property string $starter_number
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $eventRatings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participation[] $nextParticipations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organizer[] $organizerRatings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participation[] $participations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Participation[] $pastParticipations
 * @property-read \App\Models\SportType $sportType
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Visit[] $visits
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserModel confirmed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlugModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereBirthDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereSportTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereStarterNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Athlete whereUserId($value)
 * @mixin \Eloquent
 */
class Athlete extends UserModel {

    use HasResourceRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'athletes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'sport_type_id',
        'starter_number'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birth_date'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => AthleteCreated::class,
    ];

    /**
     * Listen for create event to save the slug.
     */
    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $firstNameChar = substr($model->first_name, 0, 1);
            $lastNameChar = substr($model->last_name, 0, 1);
            $birthMonth = $model->birth_date->month;
            $birthYear = $model->birth_date->format('y');
            $model->starter_number = $firstNameChar . $lastNameChar . $birthMonth . $birthYear;

            $existingStarterNumbers = Athlete::where('starter_number', $model->starter_number)->count();
            if ($existingStarterNumbers > 0) {
                $model->starter_number .= $existingStarterNumbers + 1;
            }
        }
        );
    }

    /**
     * Gets the display name of this user which acts as the username.
     *
     * @return string
     */
    public function getDisplayName() {
        return $this->getFullName();
    }

    /**
     * Get the participations of the athlete.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participations() {
        return $this->hasMany(Participation::class);
    }

    /**
     * Get the future participations of the athlete.
     *
     * @return mixed
     */
    public function nextParticipations() {
        $stateId = ParticipationState::select('id')->whereLabel('registered')->first()->id;

        return $this->hasMany(Participation::class)->where('participation_state_id', $stateId);
    }

    /**
     * Get the past participations of the athlete.
     *
     * @return mixed
     */
    public function pastParticipations() {
        $states = ParticipationState::select('id')->whereLabel('disqualified')->orWhere('label', 'ranked')->orWhere('label', 'not_started')->get();
        $stateIds = [];
        foreach ($states as $state) {
            array_push($stateIds, $state->id);
        }

        return $this->hasMany(Participation::class)->whereIn('participation_state_id', $stateIds);
    }

    /**
     * Get the visits of the athlete.

     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits() {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get the event ratings of the athlete.

     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eventRatings() {
        return $this->belongsToMany(Event::class, 'event_ratings')
            ->withPivot('rating', 'description', 'privacy')
            ->withTimestamps();
    }

    /**
     * Get the organizer ratings of the athlete.

     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizerRatings() {
        return $this->belongsToMany(Organizer::class, 'organizer_ratings')
            ->withPivot('rating', 'description', 'privacy')
            ->withTimestamps();
    }

    /**
     * Get the sport type of the athlete.

     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sportType() {
        return $this->belongsTo(SportType::class);
    }

    /**
     * Checks if the athlete is a rater of a rateable object.
     *
     * @param Rateable $rateable
     * @return bool
     */
    public function isRater($rateable) {
        return $rateable->hasRater($this);
    }

    /**
     * Gets the attribute name of the model, that shall be used for the slug of the model.
     *
     * @return string
     */
    public function getSlugName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Gets the translated title of the athlete.
     *
     * @param $value
     * @return string
     */
    public function getTitleAttribute($value) {
        if (empty($value)) {
            return '';
        }

        return \Lang::get('common.' . $value);
    }

    /**
     * Gets the full name of the athlete.
     *
     * @return string
     */
    public function getFullName() {
        return $this->title . ' ' . $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Gets the anonymous name representation of the athlete.
     *
     * @return string
     */
    public function getAnonymousName() {
        return substr($this->first_name, 0, 1) . '. ' . substr($this->last_name, 0 , 1) . '.';
    }

    /**
     * Set the athlete's first name.
     *
     * @param  string $value
     * @return void
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Set the athlete's last name.
     *
     * @param  string $value
     * @return void
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Checks if the athlete participates in an event, that has been created by a specific user.
     *
     * @param Organizer $organizer
     *
     * @return bool
     */
    public function isParticipant(Organizer $organizer) {
        foreach ($this->participations as $participation) {
            if ($participation->participationClass->isCreator($organizer->user)) {
                return true;
            }
        }

        return false;
    }

}
