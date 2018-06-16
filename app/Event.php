<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = ['article_id','full_day','start_time', 'end_time'];
    public $timestamps = false;
    protected $dates = ['start_time', 'end_time'];

    public function setStartTimeAttribute($date)
    {
        $this->attributes['start_time'] = Carbon::parse($date);
    }

    public function getStartTimeAttribute($date)
    {

        return Carbon::parse($date)->format('d.m.Y');
    }
    public function setEndTimeAttribute($date)
    {
        $this->attributes['end_time'] = Carbon::parse($date);
    }

    public function getEndTimeAttribute($date)
    {

        return Carbon::parse($date)->format('d.m.Y');
    }
    public function article()
    {
        return $this->belongsTo('App\Articles', 'id', 'article_id')->withTimestamps();
    }
}
