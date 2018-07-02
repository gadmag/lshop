<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = ['product_id','priority', 'price','date_start', 'date_end'];

    protected $table = 'product_specials';
    public $timestamps = false;

    public function setPriceAttribute($value)
    {
//        dd((float)$value);
        $this->attributes['price'] = (float)$value;
    }

    public function specialProduct()
    {
        $this->belongsTo('App\Product');
    }
}
