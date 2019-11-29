<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name', 'code', 'discount', 'status', 'uses_total', 'date_start', 'date_end'];

    protected $dates = ['date_end', 'date_start'];

    public function setDateStartAttribute($date)
    {
        $this->attributes['date_start'] = Carbon::parse($date)->format('Y-m-d');
    }

    public function getDateStartAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }

    public function getDateEndAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y');
    }


    public function setDateEndAttribute($date)
    {

        $this->attributes['date_end'] = Carbon::parse($date)->format('Y-m-d');
    }


    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeIsUses($query)
    {
        $query->where('uses_total', '>', 0);
    }

    public function scopeBetweenDate($query)
    {
        $dt = Carbon::now()->format('Y-m-d');
        $query->where('date_start', '<=', $dt)->where('date_end', '>=', $dt);
    }

    public function getByCode(string $code)
    {
        return $this->active()->isUses()->betweenDate()->whereCode($code)->firstOrFail();
    }

}
