<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $fillable = ['alias_url','aliastable_id','aliastable_type'];

    public function aliastable()
    {
        return $this->morphTo();
    }



}
