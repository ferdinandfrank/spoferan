<?php

namespace App\Models;

/**
 * App\Models\EventImage
 *
 * @property int $id
 * @property int $event_id
 * @property int $album_id
 * @property string $image
 * @property string $title
 * @property string $description
 * @property bool $privacy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\EventImageAlbum $album
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereAlbumId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventImage extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'album_id',
        'image',
        'title',
        'description',
        'privacy',
    ];

    /**
     * Gets the event the image belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Gets the album the image belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album() {
        return $this->belongsTo(EventImageAlbum::class);
    }
}
