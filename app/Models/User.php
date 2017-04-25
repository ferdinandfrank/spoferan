<?php

namespace App\Models;

use App\Events\AthleteCreated;
use App\Events\UserCreated;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Authenticatable;
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
 * @property string $current_user_type
 * @property string $confirmation_token
 * @property bool $confirmed
 * @property bool $verified
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Models\Admin $admin
 * @property-read \App\Models\Athlete $athlete
 * @property-read \App\Models\UserContact $contact
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\App\Models\DatabaseNotification[] $notifications
 * @property-read \App\Models\Organizer $organizer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentDetails[] $paymentDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read \App\Models\UserSettings $settings
 * @property-read \App\Models\SocialMedia $socialMedia
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\App\Models\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User search($searchQuery)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User searchAll($searchQuery, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User searchColumn($key, $value, $boolean = 'and', $columnRestriction = array())
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCurrentUserType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereVerified($value)
 * @mixin \Eloquent
 * @property-read \App\Models\PaymentDetails $activePaymentDetails
 */
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
        'current_user_type'
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
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => UserCreated::class,
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
     * Get the social media information of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function socialMedia() {
        return $this->morphOne(SocialMedia::class, 'holder');
    }

    /**
     * Get the corresponding user contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact() {
        return $this->hasOne(UserContact::class);
    }

    /**
     * Get the corresponding payment details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentDetails() {
        return $this->hasMany(PaymentDetails::class);
    }

    /**
     * Get the current active corresponding payment details of the user
     * based on the currently active user type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activePaymentDetails() {
        $stripeObject = 'customer';
        if ($this->current_user_type === config('spoferan.user_type.organizer')) {
            $stripeObject = 'account';
        }
        return $this->hasOne(PaymentDetails::class)->where('stripe_object', $stripeObject);
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
     * @param string
     *
     * @return bool
     */
    public function isType($type) {
        return $this->current_user_type === config('spoferan.user_type.' . $type) || $this->current_user_type === $type;
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
     * Sets a new confirmation token for the user and resets
     * the confirmation state.
     */
    public function setConfirmationToken() {
        $this->confirmation_token = bin2hex(random_bytes(10));
        $this->confirmed = false;
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
        return static::whereHas('paymentDetails', function ($query) use ($stripeId) {
            $query->where('stripe_id', $stripeId);
        })->first();
    }
}
