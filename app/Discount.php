<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['option_id', 'quantity', 'price'];

    protected $table = 'product_option_discounts';
    public $timestamps = false;

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }

    public function option()
    {
        $this->belongsTo('App\Option');
    }

    public function scopeActive($query, int $qty)
    {
        $query->where('quantity', '<=', $qty);
    }
}
