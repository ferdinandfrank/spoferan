<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\EventGroup
 *
 * @property int $id
 * @property int $organizer_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $cover
 * @property int $sport_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \App\Models\Organizer $organizer
 * @property-read \App\Models\SportType $sportType
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlugModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup search($searchQuery)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup searchAll($searchQuery, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup searchColumn($key, $value, $boolean = 'and', $columnRestriction = array())
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereOrganizerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereSportTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventGroup extends SlugModel {

    use HasResourceRoutes;
    use HasCreator;
    use HasCoverImage;
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'cover',
        'sport_type_id'
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
        'description' => 'LIKE',
        'sport_type' => [
            'sport_type_id' => SportType::class
        ]
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
     * Gets the corresponding organizer instance, which is the creator of the event group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer() {
        return $this->belongsTo(Organizer::class, 'organizer_id');
    }

    /**
     * Gets the sport type of the event group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sportType() {
        return $this->belongsTo(SportType::class);
    }

    /**
     * Gets the events of the event group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events() {
        return $this->hasMany(Event::class, 'event_group_id');
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

}