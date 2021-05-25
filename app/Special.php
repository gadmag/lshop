<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = ['product_id','priority', 'price', 'price_prefix', 'date_start', 'date_end'];

    protected $table = 'product_specials';
    public $timestamps = false;
    protected $dates = ['date_end','date_start'];

    /**
     * @param $date
     */
    public function setDateStartAttribute($date)
    {
//        dd(Carbon::parse($date)->format('Y-m-d'));
        $this->attributes['date_start'] = Carbon::parse($date)->format('Y-m-d');
    }



    /**
     * @param $date
     */
    public function setDateEndAttribute($date)
    {

        $this->attributes['date_end'] = Carbon::parse($date)->format('Y-m-d');
    }



    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }

    public function scopeIsActive($query)
    {
        $dt = Carbon::now();
        $query->where('date_start', '<=', $dt)->where('date_end', '>=', $dt);
    }


    public function specialProduct()
    {
        $this->belongsTo('App\Product');
    }

}
