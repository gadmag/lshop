<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Upload extends Model
{
    protected $table = 'uploads';
    protected $fillable = ['uploadstable_id', 'uploadstable_type', 'mime', 'filename','title','alt', 'order'];

    public function uploadstable()
    {
        return $this->morphTo();
    }



}
