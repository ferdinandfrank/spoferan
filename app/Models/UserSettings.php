<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\UserSettings
 *
 * @property int $user_id
 * @property bool $receive_newsletter
 * @property bool $privacy_profile
 * @property bool $privacy_address
 * @property bool $privacy_event_history
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSettings wherePrivacyAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSettings wherePrivacyEventHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSettings wherePrivacyProfile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSettings whereReceiveNewsletter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSettings whereUserId($value)
 * @mixin \Eloquent
 */
class UserSettings extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_settings';

    /**
     * The primary key of the table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the primary key should be incremented on insert.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * All of the relationships to be touched and which timestamps
     * shall be updated, if the timestamps of this model would be updated.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receive_ads',
        'privacy_profile',
        'privacy_address',
        'privacy_event_history',
    ];

    /**
     * Gets the user these settings belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }


}
