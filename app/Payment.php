<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ['title', 'name', 'status', 'order', 'payment_key'];



    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeOrder($query)
    {
        $query->orderBy('order', 'asc');
    }

    public static function getPayments()
    {
       return (new static)->with('files')->active()->order()->get();
    }

    public function files()
    {
        return $this->morphOne('App\Upload', 'uploadstable');
    }


    public function delete()
    {
        return parent::delete();
    }
}
