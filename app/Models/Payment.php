<?php

namespace App\Models;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $payable_id_id
 * @property string $payable_id_type
 * @property string $payment_type
 * @property int $amount
 * @property string $charge_id
 * @property string $coupon_id
 * @property string $metadata
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereChargeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereMetadata($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment wherePayableIdId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment wherePayableIdType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Coupon $coupon
 * @property int $payable_id
 * @property string $payable_type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment wherePayableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment wherePayableType($value)
 */
class Payment extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'charge_id',
        'description',
        'payable_id',
        'fee',
        'payable_type',
        'payment_type',
        'coupon_id',
        'metadata',
        'user_id'
    ];

    /**
     * Gets the user the payment details belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the coupon that was used for the payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get all of the owning payable models.
     */
    public function payable() {
        return $this->morphTo();
    }
}
