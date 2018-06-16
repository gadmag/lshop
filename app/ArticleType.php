<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ArticleType extends Model
{
   protected $table = 'article_types';
   protected  $fillable = ['name', 'title'];

   public function scopeOfArticleType($query, $type)
   {
        $query->where('name', $type);
   }

}
