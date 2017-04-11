<?php

namespace App\Models;

/**
 * App\Models\EventImageAlbum
 *
 * @property int $id
 * @property int $event_id
 * @property string $title
 * @property string $description
 * @property bool $privacy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventImage[] $images
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum wherePrivacy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EventImageAlbum whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventImageAlbum extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_image_albums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'privacy',
    ];

    /**
     * Gets the event the album belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the images of the album.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(EventImage::class);
    }
}
