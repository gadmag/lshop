<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Service\TransliteratedService;

class Page extends Model
{
    use TransliteratedService;

    protected $fillable = ['title', 'body', 'alias', 'user_id', 'status'];



    public function setAliasAttribute($alias)
    {
        if (!empty($alias)) {
            $this->attributes['alias'] = $this->transliterate($alias);
        } else {
            $this->attributes['alias'] = $this->transliterate($this->attributes['title']);
        }
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function getPages()
    {
        $this->active()->get();
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
