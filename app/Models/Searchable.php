<?php

namespace App\Models;

/**
 * Searchable
 * -----------------------
 * Type of @link Model that can be searched.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait Searchable {

    /**
     * Scopes a query by a search query to search on searchable columns as specified in the
     * search query array or an all searchable columns if a string is specified as the search query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array                         $searchQuery
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchQuery) {
        if (property_exists($this, 'searchable') && is_array($this->searchable)) {

            if (is_array($searchQuery)) {
                foreach ($searchQuery as $column => $value) {
                    if (array_key_exists($column, $this->searchable)) {
                        $query->searchColumn($column, $value);
                    } elseif ($column == 'search') {
                        $query->searchAll($value, 'or');
                    }
                }
            } else {
                $query->searchAll($searchQuery);
            }

        }

        return $query;
    }

    /**
     * Scopes a query by a search query to search on all searchable columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string                               $searchQuery
     * @param string                                $boolean
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchAll($query, $searchQuery, $boolean = 'and') {
        foreach ($this->searchable as $searchable => $operator) {
            $query->searchColumn($searchable, $searchQuery, $boolean);
        }

        return $query;
    }

    /**
     * Scopes a query by a search query to search on searchable columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param                                       $key
     * @param                                       $value
     * @param string                                $boolean
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchColumn($query, $key, $value, $boolean = 'and') {
        $operator = $this->searchable[$key];

        if (is_array($operator)) {
            $key = array_keys($operator)[0];
            $operator = $operator[$key];
        }

        if ($operator == 'LIKE') {
            $query->where($key, 'LIKE', "%$value%", $boolean);
        } elseif (method_exists($this, $operator)) {
            if ($boolean == 'and') {
                $query->whereHas($operator, function ($subQuery) use ($value) {
                    $subQuery->findByKey($value);
                });
            } else {
                $query->orWhereHas($operator, function ($subQuery) use ($value) {
                    $subQuery->findByKey($value);
                });
            }
        } elseif (class_exists($operator)) {
            $slugModel = (new $operator())::findByKey($value)->first();
            if ($slugModel) {
                $query->where($key, '=', $slugModel->getKey(), $boolean);
            }
        } else {
            $query->where($key, $operator, $value, $boolean);
        }

        return $query;
    }
}