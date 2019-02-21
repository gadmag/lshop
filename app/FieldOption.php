<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldOption extends Model
{
    protected $fillable = ['name','type'];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value[0];
    }
}
