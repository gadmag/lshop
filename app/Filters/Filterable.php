<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    public function scopeAdvancedFilter(Builder $query, QueryFilter $filter)
    {
        return $filter->process($query);
    }
}