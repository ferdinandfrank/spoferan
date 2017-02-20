<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property int $user_type
 * @property string $country
 * @property string $postcode
 * @property string $city
 * @property string $street
 * @property string $phone
 * @property string $confirmation_token
 * @property bool $confirmed
 * @property bool $verified
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\Admin $admin
 * @property-read \App\Models\Athlete $athlete
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\App\Models\DatabaseNotification[] $notifications
 * @property-read \App\Models\Organizer $organizer
 * @property-read \App\Models\UserSettings $settings
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\App\Models\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User search($attributes, $appendOrderBy = true, $defaultOperator = 'LIKE')
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePostcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUserType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereVerified($value)
 * @mixin \Eloquent
 */
class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        HasResourceRoutes,
        Searchable,
        SoftDeletes,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'avatar',
        'country',
        'postcode',
        'street',
        'phone',
        'city',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Gets the corresponding athlete instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function athlete() {
        return $this->hasOne(Athlete::class);
    }

    /**
     * Gets the corresponding organizer instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function organizer() {
        return $this->hasOne(Organizer::class);
    }

    /**
     * Gets the corresponding admin instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin() {
        return $this->hasOne(Admin::class);
    }

    /**
     * Get the corresponding user settings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings() {
        return $this->hasOne(UserSettings::class);
    }

    /**
     * Gets the display name of this user, that acts as the username.
     *
     * @return string
     */
    public function getDisplayName() {
        if ($this->isType(config('starmee.user_type.athlete'))) {
            return $this->athlete->getFullName();
        } else if ($this->isType(config('starmee.user_type.organizer'))) {
            return $this->organizer->name;
        } else if ($this->isType(config('starmee.user_type.admin'))) {
            return $this->admin->display_name;
        }

        return $this->email;
    }

    /**
     * Checks if the user is a specific type of user.
     *
     * @param string|int
     *
     * @return bool
     */
    public function isType($type) {
        if (is_string($type)) {
            return $this->user_type == config('starmee.user_type.' . $type);
        }

        return $this->user_type == $type;
    }

    /**
     * Gets the type of this user as a @link UserModel object.
     *
     * @return UserModel
     */
    public function getType() {
        if ($this->isType(config('starmee.user_type.organizer'))) {
            return $this->organizer;
        } elseif ($this->isType(config('starmee.user_type.admin'))) {
            return $this->admin;
        }

        return $this->athlete;
    }

    /**
     * Gets the type of this user as a string (defined in @link config('starmee.user_type'))
     *
     * @return string
     */
    public function getTypeAsString() {
        $type = config('starmee.user_type.athlete');
        if ($this->isType(config('starmee.user_type.organizer'))) {
            $type = config('starmee.user_type.organizer');
        } elseif ($this->isType(config('starmee.user_type.admin'))) {
            $type = config('starmee.user_type.admin');
        }

        return trans('label.user_type.' . array_search($type, config('starmee.user_type')));
    }

    /**
     * Gets the path, where the storage files of the model are located.
     *
     * @return string
     */
    public function getStoragePath() {
        return $this->getType()->getStoragePath();
    }

    /**
     * Gets the path, where the images of the model are located.
     *
     * @return string
     */
    public function getImagesPath() {
        return $this->getType()->getImagesPath();
    }

    /**
     * Gets the avatar image as a link.
     *
     * @return string
     */
    public function getAvatarLink() {
        return $this->getType()->getAvatarLink();
    }

    /**
     * Sets the event cover link.
     *
     * @param string $value
     */
    public function setAvatarAttribute($value) {
        $path = $this->getImagesPath() . '/';
        if (substr($value, 0, strlen($path)) === $path) {
            $value = substr($value, strlen($path));
        }
        $this->attributes['avatar'] = $value;
    }

    /**
     * Deletes the avatar image of the user.
     *
     * @return bool
     */
    public function deleteAvatar() {
        $avatar = $this->avatar;
        if (!empty($avatar)) {
            return $this->getType()->deleteImage($avatar);
        }

        return true;
    }

    /**
     * Sets the user's password.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Confirms the user and activates his account.
     */
    public function activate() {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }

    /**
     * Checks if the user has recently registered for the application, i.e. in the interval
     * of the given hours from now.
     *
     * @param int $hours_ago
     *
     * @return bool
     */
    public function hasRecentlyRegistered($hours_ago = 2) {
        return $this->created_at->diffInHours(Carbon::now()) < $hours_ago;
    }

    /**
     * Updates the avatar image of the user.
     *
     * @param string $imageName
     *
     * @return User
     */
    public function updateAvatar($imageName) {
        $this->avatar = $imageName;
        $this->save();

        return $this;
    }
}
