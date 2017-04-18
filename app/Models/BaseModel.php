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
 * @version 1.0
 * @package App\Models
 */
abstract class BaseModel extends Model {

    /**
     * The parents in the route paths as a string array to build the routes of the model.
     * Shall be the same as the class name of the 'belongsTo' relationship between the parent and this model.
     *
     * @return string
     */
    protected static function getRouteParent() {
        return null;
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

    /**
     * Scopes a query to find a model by its primary key name.
     *
     * @param $query
     * @param $key
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByKey($query, $key) {
        return $query->where($this->getKeyName(), $key);
    }

    /**
     * Scopes a query to only include the model without the specified id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|string|int                      $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIgnore($query, $id) {
        if (is_array($id)) {
            return $query->whereNotIn('id', $id);
        }

        return $query->where('id', '<>', $id);
    }
}