<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotificationCollection;


/**
 * App\Models\DatabaseNotification
 *
 * @property string $id
 * @property int $notifiable_id
 * @property string $notifiable_type
 * @property string $type
 * @property array $data
 * @property \Carbon\Carbon $read_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereNotifiableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereNotifiableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereReadAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\DatabaseNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DatabaseNotification extends BaseModel {

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable() {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead() {
        if (is_null($this->read_at)) {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Create a new database notification collection instance.
     *
     * @param  array $models
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function newCollection(array $models = []) {
        return new DatabaseNotificationCollection($models);
    }
}