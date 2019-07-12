<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Region extends Model
{
    protected $table = 'region';


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort_name', function (Builder $builder) {
            $builder->orderBy('name','asc');
        });
    }
}
