<?php

namespace App\Models;

use Stripe\Customer;

/**
 * App\Models\PaymentDetails
 *
 * @property int $id
 * @property int $user_id
 * @property string $stripe_id
 * @property string $stripe_object
 * @property bool $stripe_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereStripeActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereStripeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereStripeObject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentDetails whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentDetails extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stripe_id',
        'stripe_object',
        'stripe_active'
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
     * Gets the registered card for the stripe user.
     *
     * @return array|\Stripe\StripeObject
     */
    public function getCards() {
        return Customer::retrieve($this->stripe_id)->sources->all([
            "object" => "card"
        ]);
    }

    /**
     * Gets the registered bank accounts for the stripe user.
     *
     * @return array|\Stripe\StripeObject
     */
    public function getBankAccounts() {
        return Customer::retrieve($this->stripe_id)->sources->all([
            "object" => "bank_account"
        ]);
    }
}
