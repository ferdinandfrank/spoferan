<?php

namespace App\Models;

use Stripe\Customer;

class PaymentDetails extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_details';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stripe_id',
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
