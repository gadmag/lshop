<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title','type','text','status', 'price', 'product_id','order'];

    public function scopeOrder($query)
    {
        $query->orderBy('order', 'asc');
    }


    public function scopeGetByType($query, $type)
    {
        $query->whereType($type)->order()->latest('created_at');
    }

    public function serviceProducts()
    {
        return $this->hasMany('App\Product');
    }

    public function serviceUser()
    {
        return $this->belongsTo('App\User');
    }
}
