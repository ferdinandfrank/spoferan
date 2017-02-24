<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * UserModel
 * -----------------------
 * Type of @link Model that is a subclass of an user.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
abstract class UserModel extends SlugModel {

    use HasStorage;

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
     * Gets the corresponding user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes a query with including only confirmed users.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeConfirmed($query) {
        return $query->whereHas(
            'user', function($query) {
            $query->where('confirmed', true);
        }
        );
    }

    /**
     * Gets the display name of this user which acts as the username.
     *
     * @return string
     */
    public abstract function getDisplayName();
}
