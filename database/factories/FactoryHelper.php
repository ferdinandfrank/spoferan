<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * FactoryHelper
 * -----------------------
 * ${CARET}
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App
 */
class FactoryHelper {

    /**
     * Finds a random entry for the specified Eloquent model or creates
     * one if none exists.
     *
     * @param string $className
     *
     * @return Model
     */
    public static function getRandomOrCreate(string $className) {
        $model = $className::orderByRaw("RAND()")->first();
        if (empty($model)) {
            $model = factory($className)->create();
        }
        return $model;
    }
}