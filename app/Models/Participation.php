<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Participation
 *
 * @property int $id
 * @property int $starter_number
 * @property int $participation_class_id
 * @property int $athlete_id
 * @property int $participation_state_id
 * @property bool $privacy
 * @property int $rank
 * @property string $time
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Athlete $athlete
 * @property-read \App\Models\ParticipationClass $participationClass
 * @property-read \App\Models\ParticipationState $status
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereParticipationClassId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereParticipationStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereStarterNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Participation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Participation extends BaseModel {

    use SoftDeletes;
    use HasResourceRoutes;
    use HasAnonymousAthletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'participation_class_id',
        'club_id',
        'description',
        'privacy',
        'rank',
        'time',
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

}

