<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
   protected $fillable = ['product_id','quantity','price','price_prefix', 'date_start', 'date_end'];

    protected $table = 'product_discounts';
    public $timestamps = false;

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }
    public function discountProduct()
   {
       $this->belongsTo('App\Product');
   }
}
