<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait Sortable
{
    /**
     * Scope a query to sort results.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortable(Builder $query, Request $request)
    {
        $sortBy    = $request->get('sortBy');
        $direction = $request->boolean('desc', false) ? 'desc' : 'asc';

        // Ensure column to sort is part of model's sortables property and exists
        if ($sortBy
            && in_array($sortBy, $this->sortables)
            && Schema::hasColumn($this->getTable(), $sortBy)) {

            return $query->orderBy($sortBy, $direction);
        }

        return $query;
    }
}
