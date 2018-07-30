<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }



    public function regions()
    {
        return $this->hasMany('App\Region');
    }
}
