<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldOption extends Model
{
    protected $fillable = ['name','type','order'];

    public function scopeOrder($query)
    {
        $query->orderBy('order', 'asc');
    }


}
