<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['first_name', 'last_name', 'telephone', 'email', 'company', 'address', 'postcode',
        'city', 'country', 'region', 'comment', 'coupon', 'user_id', 'cart', 'address', 'payment_id', 'payment_name'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
