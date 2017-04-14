<?php

namespace App\Models;

use DB;


/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel findByKey($key)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BaseModel ignore($id)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Settings whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Settings whereValue($value)
 * @mixin \Eloquent
 */
class Settings extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Gets the title of the page.
     *
     * @return string
     */
    public static function title() {
        return self::getByName('title');
    }

    /**
     * Gets the subtitle of the page.
     *
     * @return string
     */
    public static function subtitle() {
        return self::getByName('subtitle');
    }

    /**
     * Gets the description of the page.
     *
     * @return string
     */
    public static function description() {
        return self::getByName('description');
    }

    /**
     * Gets the stripe_cc_fee_percent of the page.
     *
     * @return string
     */
    public static function stripeCCFeePercent() {
        return self::getByName('stripe_cc_fee_percent');
    }

    /**
     * Gets the stripe_cc_fee_amount of the page.
     *
     * @return string
     */
    public static function stripeCCFeeAmount() {
        return self::getByName('stripe_cc_fee_amount');
    }

    /**
     * Gets the short description of the page.
     *
     * @return string
     */
    public static function shortDescription() {
        return self::getByName('description_short');
    }

    /**
     * Gets the logo of the page.
     *
     * @return string
     */
    public static function logo() {
        $link = self::getByName('logo');
        if (empty($link)) {
            $link = asset('images/logo.png');
        }

        return $link;
    }

    /**
     * Gets the favicon of the page.
     *
     * @return string
     */
    public static function favicon() {
        $link = self::getByName('favicon');
        if (empty($link)) {
            $link = asset('images/favicon.png');
        }

        return $link;
    }

    /**
     * Gets the background image of the page.
     *
     * @return string
     */
    public static function background() {
        $link = self::getByName('background');
        if (empty($link)) {
            $link = asset('images/background.jpg');
        }

        return $link;
    }

    /**
     * Gets the seo keywords of the page.
     *
     * @return string
     */
    public static function seoKeywords() {
        return self::getByName('seo_keywords');
    }

    /**
     * Gets the contact email address of the page.
     *
     * @return string
     */
    public static function contactEmail() {
        return self::getByName('email_contact');
    }

    /**
     * Gets the technical contact email address of the page.
     *
     * @return string
     */
    public static function technicalEmail() {
        return self::getByName('email_technical');
    }

    /**
     * Gets the slug to the facebook page of the page.
     *
     * @return string
     */
    public static function facebook() {
        return self::getByName('facebook');
    }

    /**
     * Gets the slug to the twitter page of the page.
     *
     * @return string
     */
    public static function twitter() {
        return self::getByName('twitter');
    }

    /**
     * Gets the imprint of the page.
     *
     * @return string
     */
    public static function imprint() {
        return self::getByName('imprint');
    }

    /**
     * Gets the slug to the instagram page of the page.
     *
     * @return string
     */
    public static function instagram() {
        return self::getByName('instagram');
    }

    /**
     * Gets the author of the page.
     *
     * @return string
     */
    public static function author() {
        return self::getByName('author');
    }

    /**
     * Gets the value settings by name.
     *
     * @param string $settingName
     *
     * @return string
     */
    public static function getByName($settingName) {
        return self::where('key', $settingName)->pluck('value')->first();
    }

    /**
     * Updates the model in the database.
     *
     * @param  array $attributes
     *
     * @return bool
     */
    public static function updateAll(array $attributes = []) {
        DB::transaction(function () use ($attributes) {
            foreach ($attributes as $attribute => $value) {
                $setting = Settings::where('key', $attribute)->first();
                if (!empty($setting)) {
                    $setting->value = $value;
                    $setting->update();
                }
            }
        });

        return true;
    }


}
