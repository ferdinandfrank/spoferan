<?php

namespace App\Models;

use App\Events\AthleteCreated;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;


class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        HasResourceRoutes,
        Searchable,
        SoftDeletes,
        HasAddress,
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
     * Get the corresponding payment details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentDetails() {
        return $this->hasOne(PaymentDetails::class);
    }

    /**
     * Get the payments the user made.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments() {
        return $this->hasMany(Payment::class);
    }

    /**
     * Gets the display name of this user which acts as the username.
     *
     * @return string
     */
    public function getDisplayName() {
        if (count($this->athlete)) {
            return $this->athlete->getDisplayName();
        } else if (count($this->organizer)) {
            return $this->organizer->getDisplayName();
        } else if (count($this->admin)) {
            return $this->admin->getDisplayName();
        }

        return $this->email;
    }

    /**
     * Gets the avatar of the user.
     *
     * @param $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar) {
        return $avatar ?? asset('images/avatar_default.png');
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
            return $this->user_type == config('spoferan.user_type.' . $type);
        }

        return $this->user_type == $type;
    }

    /**
     * Gets the type of this user as a @link UserModel object.
     *
     * @return UserModel
     */
    public function getType() {
        if ($this->isType(config('spoferan.user_type.organizer'))) {
            return $this->organizer;
        } elseif ($this->isType(config('spoferan.user_type.admin'))) {
            return $this->admin;
        }

        return $this->athlete;
    }

    /**
     * Gets the type of this user as a string (defined in @link config('spoferan.user_type'))
     *
     * @return string
     */
    public function getTypeAsString() {
        $type = config('spoferan.user_type.athlete');
        if ($this->isType(config('spoferan.user_type.organizer'))) {
            $type = config('spoferan.user_type.organizer');
        } elseif ($this->isType(config('spoferan.user_type.admin'))) {
            $type = config('spoferan.user_type.admin');
        }

        return trans('label.user_type.' . array_search($type, config('spoferan.user_type')));
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
     * Finds an user by its stripe id.
     *
     * @param $stripeId
     *
     * @return User
     */
    public static function findByStripeId($stripeId) {
        return static::whereHas('paymentDetails', function ($query) use($stripeId) {
            $query->where('stripe_id', $stripeId);
        })->first();
    }
}
