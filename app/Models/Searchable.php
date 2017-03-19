<?php

namespace App\Models;

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

    /**
     * Scopes a query by a search query to search on specific columns.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param  string|array                         $searchQuery
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchQuery) {
        if (property_exists($this, 'searchable') && is_array($this->searchable)) {

            if (is_array($searchQuery)) {
                foreach ($searchQuery as $key => $value) {
                    if (in_array($key, $this->searchable)) {
                        $query = $this->searchByType($query, $key, $value);
                    } elseif ($key == 'search') {
                        foreach ($this->searchable as $searchable) {
                            $query = $this->searchByType($query, $searchable, $value);
                        }
                    }
                }
            } else {
                foreach ($this->searchable as $searchable) {
                    $query = $this->searchByType($query, $searchable, $searchQuery);
                }
            }

        }

        return $query;
    }

    private function searchByType($query, $key, $value) {
        \Log::alert($key . " -< " . gettype($this[$key]));
        switch (gettype($this[$key])) {
            case "string":
                $query->orWhere($key, 'LIKE', "%$value%");
                break;
            default:
                $query->orWhere($key, $value);
                break;
        }

        return $query;
    }
}