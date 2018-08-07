<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = ['product_id','priority', 'price','date_start', 'date_end'];

    protected $table = 'product_specials';
    public $timestamps = false;
    protected $dates = ['date_end','date_start'];

    /**
     * @param $date
     */
    public function setDateStartAttribute($date)
    {
        $this->attributes['date_start'] = Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getDateStartAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }

    /**
     * @param $date
     */
    public function setDateEndAttribute($date)
    {

        $this->attributes['date_end'] = Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * @param $date
     * @return mixed
     */
    public function getDateEndAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }

    public function scopeBetweenDate($query)
    {
        $dt = Carbon::now();
        $query->where('date_start', '<=', $dt)->where('date_end', '>=', $dt);
    }


    public function specialProduct()
    {
        $this->belongsTo('App\Product');
    }
}
