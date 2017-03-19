<?php

namespace App\Models;

use DB;
use Illuminate\Http\Request;

/**
 * SlugModel
 * -----------------------
 * Type of @link Model whose route key is a slug.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
abstract class SlugModel extends BaseModel {

    /**
     * Gets the column name to use for resolving the model object.
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey() {
        return $this->getAttribute('slug');
    }

    /**
     * Listen for create event to save the slug.
     */
    protected static function boot() {
        parent::boot();
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty($model->getSlugName())) {
                $slug = $model->createUniqueSlug();
                $model->slug = $slug;
            }
        }
        );
    }

    /**
     * Gets the attribute name of the model, that shall be used for the slug of the model.
     *
     * @return string
     */
    public abstract function getSlugName();

    /**
     * Creates an unique slug for the model.
     *
     * @return string
     */
    public function createUniqueSlug() {
        $slug = str_slug($this->getSlugName(), '-');
        $count = DB::table($this->getTable())
                   ->where('slug', 'like', $slug . '%')
                   ->where($this->getKeyName(), '<>', $this->getKey())
                   ->count();
        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    /**
     * Finds a slug model by its primary key or its slug name.
     *
     * @param $key
     *
     * @return SlugModel
     */
    public static function findByKey($key) {
        $model = new static();

        return static::where($model->getKeyName(), $key)->orWhere($model->getRouteKeyName(), $key)->first();
    }
}
