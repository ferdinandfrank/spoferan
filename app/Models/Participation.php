<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Participation
 *
 * @property int $id
 * @property string $starter_number
 * @property int $participation_class_id
 * @property int $athlete_id
 * @property int $club_id
 * @property int $participation_state_id
 * @property bool $privacy
 * @property int $rank
 * @property string $description
 * @property string $metadata
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Athlete $athlete
 * @property-read \App\Models\ParticipationClass $participationClass
 * @property-read \App\Models\ParticipationState $status
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereClubId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereMetadata($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereParticipationClassId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereParticipationStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereStarterNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Participation extends BaseModel {

    use SoftDeletes;
    use HasResourceRoutes;
    use HasAnonymousAthletes;
    use IsPayable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'participation_class_id',
        'description',
        'privacy',
        'athlete_id',
        'rank',
        'metadata',
        'starter_number',
        'participation_state_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Gets the participation class of the participation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participationClass() {
        return $this->belongsTo(ParticipationClass::class);
    }

    /**
     * Gets the status of the participation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status() {
        return $this->belongsTo(ParticipationState::class, 'participation_state_id');
    }

    /**
     * The parents in the route paths as a string array to build the routes of the model.
     * Shall be the same as the class name of the 'belongsTo' relationship between the parent and this model.
     *
     * @return string
     */
    protected static function getRouteParent() {
        return 'participationClass';
    }

    /**
     * Scopes the query to only include participations of the specified athlete whose event has not yet started.
     *
     * @param Builder $query
     * @param UserModel|User|null $athlete
     * @return Builder
     */
    public function scopeFuture($query, $athlete = null) {

        // Get the id of the specified athlete
        if (!$athlete) {
            if (\Auth::check()) {
                $athlete = \Auth::id();
            } else {
                return $query;
            }
        } elseif ($athlete instanceof UserModel) {
            $athlete = $athlete->user_id;
        } elseif ($athlete instanceof User) {
            $athlete = $athlete->id;
        }

        return $query->where('athlete_id', $athlete)->whereHas('participationClass', function ($subQuery) {
            $subQuery->whereDate('start_date', '>', Carbon::now());
        });
    }

    /**
     * Scopes the query to only include participations of the specified athlete whose event has already finished.
     *
     * @param Builder $query
     * @param UserModel|User|null $athlete
     * @return Builder
     */
    public function scopePast($query, $athlete = null) {

        // Get the id of the specified athlete
        if (!$athlete) {
            if (\Auth::check()) {
                $athlete = \Auth::id();
            } else {
                return $query;
            }
        } elseif ($athlete instanceof UserModel) {
            $athlete = $athlete->user_id;
        } elseif ($athlete instanceof User) {
            $athlete = $athlete->id;
        }

        return $query->where('athlete_id', $athlete)->whereHas('participationClass', function ($subQuery) {
            $subQuery->whereDate('end_date', '<', Carbon::now());
        });
    }
}

