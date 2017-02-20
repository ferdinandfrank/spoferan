<?php

namespace App\Models;

use File;
use Storage;

/**
 * HasStorage
 * -----------------------
 * Type of @link Model that has an own storage.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait HasStorage {

    /**
     * Gets the path, where the storage files of the model are located.
     *
     * @return string
     */
    public function getStoragePath() {
        return $this->getTable() . '/' . $this->getKey();
    }

    /**
     * Deletes the storage folder with all files of the model.
     *
     * @return bool
     */
    protected function deleteStorage() {
        $path = substr(config('filesystems.disks.public.root'), strlen(config('filesystems.disks.local.root') . '/')) . '/' . $this->getStoragePath();

        return Storage::deleteDirectory($path);
    }

    /**
     * Gets the path, where the images of the model are located.
     *
     * @return string
     */
    public function getImagesPath() {
        return $this->getStoragePath() . '/images';
    }

    /**
     * Removes the specified resource from storage folder of the model.
     *
     * @param string $fileName
     * @return bool
     */
    function deleteImage($fileName) {

        // Append the models images path to the filename if it doesn't exist yet
        $imagesPath = $this->getImagesPath();
        if (substr($fileName, 0, strlen($imagesPath)) !== $imagesPath) {
            $fileName = $this->getImagesPath() . '/' . $fileName;
        }

        $imagePath = config('filesystems.disks.public.root') . '/' . $fileName;

        // Make sure the files exists and to not delete the default image!
        if (File::exists($imagePath)) {
            return File::delete($imagePath);
        }

        return false;
    }

    /**
     * Forces a hard delete and deletes the storage files of the model.
     *
     * @return bool
     */
    public function totalDelete() {
        $deleted = $this->forceDelete();

        if ($deleted) {
            $this->deleteStorage();

            return true;
        }

        return false;
    }
}