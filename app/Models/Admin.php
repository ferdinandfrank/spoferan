<?php

namespace App\Models;


/**
 * App\Models\Admin
 *
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $display_name
 * @property string $slug
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserModel confirmed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUserId($value)
 * @mixin \Eloquent
 */
class Admin extends UserModel {

    use HasResourceRoutes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'display_name'
    ];

    /**
     * Gets the attribute name of the model, that shall be used for the slug of the model.
     *
     * @return string
     */
    public function getSlugName() {
        return $this->display_name;
    }

    /**
     * Set the admin's first name.
     *
     * @param  string $value
     * @return void
     */
    public function setFirstNameAttribute($value) {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Set the admin's last name.
     *
     * @param  string $value
     * @return void
     */
    public function setLastNameAttribute($value) {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Set the admin's display name.
     *
     * @param  string $value
     * @return void
     */
    public function setDisplayNameAttribute($value) {
        $this->attributes['display_name'] = ucfirst($value);
    }
}
