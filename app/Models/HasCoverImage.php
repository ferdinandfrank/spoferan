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
     * Deletes the main image of the model.
     *
     * @return bool
     */
    public function deleteCover() {
        $cover = $this[$this->getCoverProperty()];
        if (!empty($cover)) {
            return $this->deleteImage($cover);
        }

        return true;
    }

    /**
     * Updates the main image of the model.
     *
     * @param string $imageName
     *
     * @return BaseModel
     */
    public function updateCover($imageName) {
        $this[$this->getCoverProperty()] = $imageName;
        $this->save();

        return $this;
    }

    /**
     * Gets the main image of the model as a link.
     *
     * @return string
     */
    public function getCoverLink() {
        if ($this[$this->getCoverProperty()] == null) {
            return $this->getDefaultCover();
        }

        return asset('storage/' . $this[$this->getCoverProperty()]);
    }

    /**
     * Gets the url of the model's default main image.
     *
     * @return string
     */
    protected function getDefaultCover() {
        return asset('img/event_default.jpg');
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