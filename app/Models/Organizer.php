<?php

namespace App\Models;

use App\Events\OrganizerCreated;

/**
 * App\Models\Organizer
 *
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Athlete[] $raters
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserModel confirmed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SlugModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organizer whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organizer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organizer whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Organizer whereUserId($value)
 * @mixin \Eloquent
 */
class Organizer extends UserModel {

    use HasResourceRoutes;
    use Rateable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => OrganizerCreated::class,
    ];

    /**
     * Gets the attribute name of the model, that shall be used for the slug of the model.
     *
     * @return string
     */
    public function getSlugName() {
        return $this->name;
    }

    /**
     * Gets the display name of this user which acts as the username.
     *
     * @return string
     */
    public function getDisplayName() {
        return $this->name;
    }

    /**
     * Gets the events the organizer created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events() {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Sets the organizers name.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucfirst($value);
    }

}
