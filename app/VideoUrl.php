<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoUrl extends Model
{
    protected $fillable = ['article_id','url'];
    public $timestamps = false;
}
