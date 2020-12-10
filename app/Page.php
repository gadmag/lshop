<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Services\TransliteratedService;
use Illuminate\Support\Str;

class Page extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'body', 'alias', 'user_id', 'status'];

    public function sluggable()
    {
        return [
            'alias' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function getPages()
    {
        $this->active()->get();
    }

    public function getMetaTitleAttribute()
    {

        if ($this->pageSeo()->exists() && $this->pageSeo->meta_title) {
            return $this->pageSeo->meta_title;
        }

        if (setting('app_title')) {
            return setting('app_title');
        }
        return sprintf('%s | %s',setting('app_name'),$this->title);
    }

    public function getMetaDescriptionAttribute()
    {

        if ($this->pageSeo()->exists() && $this->pageSeo->meta_description) {
            return $this->pageSeo->meta_description;
        }
        if (setting('app_description')) {
            return setting('app_description');
        }
        return Str::words(strip_tags(trim($this->body)), 70);
    }

    public function getMetaKeywordsAttribute()
    {
        if ($this->pageSeo()->exists() && $this->pageSeo->meta_keywords) {
            return $this->pageSeo->meta_keywords;
        }
        if (setting('app_keywords')) {
            return setting('app_keywords');
        }
        return sprintf('%s | %s',setting('app_name'),$this->title);
    }


    /**
     * Получить  пользователя страницы
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pageUser()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function pageMenu()
    {
        return $this->morphOne('App\Menu', 'menu_linktable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function pageSeo()
    {
        return $this->morphOne('App\Seo', 'seostable');
    }


    public function delete()
    {
        $this->pageMenu()->delete();
        $this->pageSeo()->delete();
        return parent::delete();
    }
}
