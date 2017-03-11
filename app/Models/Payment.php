<?php

namespace App\Models;

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
        'user_id'
    ];

    /**
     * Gets the user the payment details belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'payment_detail_id');
    }
}
