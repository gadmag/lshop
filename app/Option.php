<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Option extends Model
{
    protected $fillable = ['product_id', 'sku', 'color', 'color_stone', 'price', 'weight', 'quantity'];
    protected $table = 'product_options';

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }


    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = (float)$value;
    }


    public function optionProduct()
    {
        $this->belongsTo('App\Product');
    }

    public function scopeColorType($query, $type)
    {
      return  $query->whereType($type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function files()
    {
        return $this->morphMany('App\Upload', 'uploadstable');
    }


    public function discount()
    {
        return $this->hasOne('App\Discount');
    }

   public function getDiscountPrice(int $qty)
   {
       if ($this->discount()->exists() && ($qty >= $this->discount()->quantity)){
            return $this->discount()->first();
       }
   }
}
