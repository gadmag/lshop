<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['title','region','body','weight', 'css_class','status'];

    public function scopePublished($query)
    {
        $query->where('status', 1);
    }

    public function scopeWeight($query)
    {
        $query->orderBy('weight','desc');
    }
}
