<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['first_name', 'last_name', 'telephone', 'email', 'company', 'address', 'postcode',
        'city', 'country', 'region', 'comment', 'comment_admin', 'coupon', 'shipment_price',
        'is_send', 'user_id', 'cart', 'address', 'payment_id', 'payment_method', 'totalPrice'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
