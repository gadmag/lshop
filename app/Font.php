<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Font extends Model
{
    protected $table = 'fonts';

    protected $fillable = [ 'title', 'code'];

    public $timestamps = false;
}
