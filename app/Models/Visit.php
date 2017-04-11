<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Visit
 *
 * @property int $id
 * @property int $athlete_id
 * @property int $visit_class_id
 * @property bool $privacy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Models\Athlete $athlete
 * @property-read \App\Models\VisitClass $visitClass
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereAthleteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Visit whereVisitClassId($value)
 * @mixin \Eloquent
 */
class Visit extends BaseModel {

    use SoftDeletes;
    use HasResourceRoutes;
    use HasAnonymousAthletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_class_id',
        'privacy',
        'athlete_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Gets the visit class of the visit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitClass() {
        return $this->belongsTo(VisitClass::class);
    }

}

