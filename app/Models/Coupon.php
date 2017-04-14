<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $code
 * @property int $creator_id
 * @property int $amount_off
 * @property bool $percent_off
 * @property string $redeem_start
 * @property string $redeem_end
 * @property string $type
 * @property int $max_redemptions
 * @property int $times_redeemed
 * @property bool $valid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $payments
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereAmountOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCreatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereMaxRedemptions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon wherePercentOff($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereRedeemEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereRedeemStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereTimesRedeemed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereValid($value)
 * @mixin \Eloquent
 * @property int $event_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon redeemable($purchaseType = null, \App\Models\Event $event = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereEventId($value)
 */
class Coupon extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'creator_id',
        'amount_off',
        'percent_off',
        'redeem_start',
        'redeem_end',
        'type',
        'max_redemptions',
        'times_redeemed',
        'valid',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['redeem_start', 'redeem_end'];

    /**
     * The types a coupon is redeemable for.
     *
     * @var array
     */
    public static $types = [
        'participation' => 'participation',
        'visit'         => 'visit',
        'all'           => 'all'
    ];

    /**
     * Gets the creator of the coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the payments on which this coupon was used.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments() {
        return $this->hasMany(User::class);
    }

    /**
     * Generates an unique coupon code.
     *
     * @return string
     */
    public static function generate() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        do {
            $code = "";
            for ($i = 0; $i < config('validation.coupon.code.max'); $i++) {
                $code .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
        } while (Coupon::whereCode($code)->count() > 0);

        return $code;
    }

    /**
     * Increases the redemption count of the coupon.
     */
    public function increaseRedemption() {
        $this->times_redeemed = $this->times_redeemed + 1;
        $this->save();
    }

    /**
     * Checks if the coupon is valid for the specified purchase type and the event.
     *
     * @param string|null $purchaseType
     * @param Event|null $event
     * @return bool
     */
    public function isRedeemable($purchaseType = null, Event $event = null) {
        $now = Carbon::now();

        if (!$this->valid) {
            return false;
        }

        // Check the purchase type
        if ($purchaseType && in_array($purchaseType, self::$types) && $purchaseType != $this->type) {
            return false;
        }

        // Check the event
        if ($event && $this->event_id != $event->id) {
            return false;
        }

        // Check max redemptions
        if ($this->max_redemptions && $this->times_redeemed >= $this->max_redemptions) {
            return false;
        }

        // Check coupon validity interval
        if ($this->redeem_start && $this->redeem_start->gt($now)) {
            return false;
        }
        if ($this->redeem_end && $this->redeem_end->lte($now)) {
            return false;
        }

        return true;
    }

    /**
     * Scopes a query to only include valid and redeemable coupons for the specified purchase.
     *
     * @param Builder $query
     * @param string|null $purchaseType
     *
     * @param Event|null $event
     * @return Builder
     */
    public function scopeRedeemable($query, $purchaseType = null, Event $event = null) {
        $now = Carbon::now();

        // Check the purchase type
        if ($purchaseType && in_array($purchaseType, self::$types)) {
            $query->where('type','all')->orWhere('type', $purchaseType);
        }

        // Check the event
        if ($event) {
            $query->where('event_id', $event->id)->orWhereNull('event_id');
        }

        return $query->where('valid', true)
            ->where(function ($subQuery) {
                $subQuery->whereNull('max_redemptions')
                         ->orWhereRaw('max_redemptions > times_redeemed');
            })
            ->where(function ($subQuery) use ($now) {
                $subQuery->whereNull('redeem_start')->orWhereDate('redeem_start', '<', $now);
            })
            ->where(function ($subQuery) use ($now) {
                $subQuery->whereNull('redeem_end')->orWhereDate('redeem_end', '>', $now);
            });
    }
}
