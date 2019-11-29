<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['first_name', 'last_name', 'telephone', 'email', 'company', 'address', 'postcode',
        'city', 'country', 'region', 'comment', 'comment_admin', 'shipment', 'is_send', 'order_status_id',
        'user_id', 'cart', 'address', 'payment', 'totalPrice'];


    public function setCartAttribute($value)
    {
        $value['instance'] = 'order';
        $this->attributes['cart'] = serialize($value);
    }

    public function getCartAttribute($value)
    {
        return unserialize($value);
    }


    public function getPaymentAttribute($value)
    {
        return json_decode($value);
    }


    public function getShipmentAttribute($value)
    {
        return json_decode($value);
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'order_status_id');
    }
}
