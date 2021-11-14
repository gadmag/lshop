<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = ['first_name', 'last_name', 'telephone', 'email', 'company', 'address', 'postcode',
        'city', 'country', 'region', 'comment', 'comment_admin', 'shipment', 'is_send', 'order_status_id',
        'user_id', 'cart', 'address', 'payment', 'totalPrice'];

//    protected $casts = [
//        'payment' => 'array',
//
//    ];

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
//
//    public function setPaymentAttribute($value)
//    {
//        $this->attributes['payment'] = json_encode($value);
//    }


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

    public function files()
    {
        return $this->morphMany('App\Upload', 'uploadstable');
    }

    public function countDefaultStatus()
    {
        return DB::table('orders')
            ->where('visited','=',0)->count();
    }
}
