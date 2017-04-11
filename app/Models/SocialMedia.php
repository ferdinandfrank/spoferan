<?php

namespace App\Models;

/**
 * App\Models\SocialMedia
 *
 * @property int $id
 * @property int $holder_id
 * @property string $holder_type
 * @property string $website
 * @property string $facebook
 * @property string $instagram
 * @property string $youtube
 * @property string $snapchat
 * @property string $twitter
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $holder
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereFacebook($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereHolderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereHolderType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereInstagram($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereSnapchat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereTwitter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SocialMedia whereYoutube($value)
 * @mixin \Eloquent
 */
class SocialMedia extends BaseModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'social_medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website',
        'facebook',
        'instagram',
        'youtube',
        'snapchat',
        'twitter',
    ];

    /**
     * Get the holder of the social media info.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function holder() {
        return $this->morphTo();
    }
}
