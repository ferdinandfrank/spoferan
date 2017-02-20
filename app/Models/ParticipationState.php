<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ParticipationState
 *
 * @property int $id
 * @property string $label
 * @property string $color
 * @property bool $selectable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationState isSelectable()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationState whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationState whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationState whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ParticipationState whereSelectable($value)
 * @mixin \Eloquent
 */
class ParticipationState extends Model {

    use IsSelectable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participation_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'color'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


}
