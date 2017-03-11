<?php

namespace App\Models;

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
}
