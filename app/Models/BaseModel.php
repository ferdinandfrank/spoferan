<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * BaseModel
 * -----------------------
 * Extension of the eloquent model class.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
abstract class BaseModel extends Model {

    public function getFillab() {
        
    }

    /**
     * The parents in the route paths as a string array to build the routes of the model.
     * Shall be the same as the class name of the 'belongsTo' relationship between the parent and this model.
     *
     * @return array
     */
    protected static function getRouteParents() {
        return [];
    }

    /**
     * Gets the route name of the model used in the routes file of the application.
     *
     * @return string
     */
    protected function getRouteId() {
        $routeId = $this->getTable();

        // Replace '_' with '-' for restful routes
        return str_replace("_", "-", $routeId);
    }

    /**
     * Gets the route key name of the model, without its table name, if the table name has been appended to the key name.
     *
     * @return string
     */
    public function getCleanRouteKeyName() {
        $keyNameParts = explode(".", $this->getRouteKeyName());
        return array_pop($keyNameParts);
    }
}