<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * FactoryHelper
 * -----------------------
 * Helper class to create fake database entries.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App
 */
class FactoryHelper {

    /**
     * Finds a random entry for the specified Eloquent model with the specified where params
     * or creates one with the params if none exists.
     *
     * @param string     $className
     * @param array $params
     *
     * @return Model
     */
    public static function getRandomOrCreate(string $className, array $params = []) {
        $model = $className::where($params)->orderByRaw("RAND()")->first();
        if (empty($model)) {
            $model = factory($className)->create($params);
        }
        return $model;
    }
}