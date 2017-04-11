<?php

namespace App\Models;

/**
 * App\Models\Label
 *
 * @property int $id
 * @property string $label
 * @property string $icon
 * @property bool $selectable
 * @property int $price
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereSelectable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Label whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Label extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'labels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'icon',
        'selectable',
        'price',
    ];

    /**
     * Get the events that own this label.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events() {
        return $this->belongsToMany(Event::class, 'event_labels');
    }
}
