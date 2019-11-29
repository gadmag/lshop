<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Country extends Model
{
    protected $table = 'country';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sort_name', function (Builder $builder) {
            $builder->orderBy('name','asc');
        });
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }



    public function regions()
    {
        return $this->hasMany('App\Region');
    }

}
