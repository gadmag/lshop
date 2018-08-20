<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['product_id','color','price','price_prefix','weight','weight_prefix', 'quantity'];
    protected $table = 'product_options';

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }


    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = (int)$value;
    }
    

    public function optionProduct()
    {
        $this->belongsTo('App\Product');
    }
}
