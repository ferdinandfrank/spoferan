<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Searchable
 * -----------------------
 * Type of @link Model can be searched.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 0.1
 * @package App\Models
 */
trait Searchable {

    protected static $queryNamespace = '\\App\\Queries\\';

    /**
     * Scope a query to include events that match the given request inputs.
     *
     * @param Builder $query
     * @param array $attributes
     * @param bool $appendOrderBy
     * @param string $defaultOperator
     * @return Builder
     */
    public function scopeSearch(Builder $query, array $attributes, $appendOrderBy = true, $defaultOperator = 'LIKE') {
        $queryClass = static::$queryNamespace . class_basename(get_class($this)) . 'Query';

        return (new $queryClass($query))->search($attributes, $appendOrderBy, $defaultOperator);
    }
}