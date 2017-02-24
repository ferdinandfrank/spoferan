<?php

namespace App\Models;

/**
 * HasCoverImage
 * -----------------------
 * Type of @link BaseModel that has a cover image.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasCoverImage {

    /**
     * Gets the main image of the model as a link.
     *
     * @param $cover
     *
     * @return string
     */
    public function getCoverAttribute($cover) {
        return $cover ?? $this->getDefaultCover();
    }

    /**
     * Gets the url of the model's default main image.
     *
     * @return string
     */
    protected function getDefaultCover() {
        return asset('images/event_default.jpg');
    }

    /**
     * Gets the name of the model's main image property.
     *
     * @return string
     */
    protected function getCoverProperty() {
        return 'cover';
    }
}