<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seos';
    protected $fillable = ['seostable_id', 'seostable_type', 'meta_title','meta_description','meta_keywords'];

    public $timestamps = false;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seostable()
    {
        return $this->morphTo();
    }
}
