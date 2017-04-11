<?php

namespace App\Models;

/**
 * App\Models\UserContact
 *
 * @property int $user_id
 * @property string $phone
 * @property string $mobile
 * @property string $country
 * @property string $state
 * @property string $postcode
 * @property string $city
 * @property string $street
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact wherePostcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserContact whereUserId($value)
 * @mixin \Eloquent
 */
class UserContact extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_contacts';

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
        'phone',
        'mobile',
        'country',
        'state',
        'postcode',
        'city',
        'street'
    ];

    /**
     * Gets the user this contact belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
