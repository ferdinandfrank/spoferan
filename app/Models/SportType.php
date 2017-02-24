<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\SportType
 *
 * @property int $id
 * @property string $label
 * @property string $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Athlete[] $athletes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SportType whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SportType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SportType whereLabel($value)
 * @mixin \Eloquent
 */
class SportType extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sport_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'icon'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Gets the events of the sport type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events() {
        return $this->hasMany(Event::class);
    }

    /**
     * Gets the athletes of the sport type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function athletes() {
        return $this->hasMany(Athlete::class);
    }

    /**
     * Gets the icon as an url.
     *
     * @param string $value
     *
     * @return string
     */
    public function getIconAttribute($value) {
        return $value ?? asset('images/avatar_default.png');
    }

}
