<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name','code','discount','uses_total','status','date_start', 'date_end'];
}
