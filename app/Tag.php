<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    /** Получить все статьи данного тега
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {

        return $this->belongsToMany('App\Articles', 'article_tag','tag_id','article_id')->withTimestamps();

    }
}
