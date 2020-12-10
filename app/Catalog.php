<?php

namespace App;

use App\Services\TreeService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Services\TransliteratedService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Catalog extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'parent_id', 'description', 'alias', 'status', 'user_id', 'type', 'order'];

    public function sluggable()
    {
        return [
            'alias' => [
                'source' => 'name'
            ]
        ];
    }

    public function getMetaTitleAttribute()
    {

        if ($this->catalogSeo->meta_title) {
            return $this->catalogSeo->meta_title;
        }

        if (setting('catalog_title')) {
            return setting('catalog_title');
        }
        return sprintf('%s | %s',setting('app_name'),$this->name);
    }

    public function getMetaDescriptionAttribute()
    {

        if ($this->catalogSeo->meta_description) {
            return $this->catalogSeo->meta_description;
        }
        if (setting('catalog_description')) {
            return setting('catalog_description');
        }
        return Str::words(strip_tags(trim($this->body)), 70);
    }

    public function getMetaKeywordsAttribute()
    {
        if ($this->catalogSeo->meta_keywords) {
            return $this->catalogSeo->meta_keywords;
        }
        if (setting('catalog_keywords')) {
            return setting('catalog_keywords');
        }
        return sprintf('%s | %s',setting('app_name'),$this->name);
    }

    public function scopePublished($query)
    {
        $query->where('status', 1);
    }

    public function scopeOrder($query)
    {
        $query->orderBy('order', 'ASC');
    }

    public function scopeUnpublished($query)
    {
        $query->where('status', 0);
    }

    public function scopeOfType($query, $type)
    {
        $query->where('type', $type);
    }


    public function scopeExcludeSelf($query, $id)
    {
        $query->where([
            ['id', '!=', $id]
        ]);
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value;
    }

    public function getParentListAttribute()
    {
        return $this->pluck('id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Catalog', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Catalog', 'parent_id');
    }


    /**
     * Список статей категории
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->morphedByMany('App\Product', 'cataloggable');

    }

    /**
     * Меню аттрибуты каталога
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function catalogMenu()
    {
        return $this->morphOne('App\Menu', 'menu_linktable');
    }

    /**
     * Seo аттрибуты каталога
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function catalogSeo()
    {
        return $this->morphOne('App\Seo', 'seostable');
    }


    /**
     * Получить файлы каталога
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->morphMany('App\Upload', 'uploadstable');
    }

    function delete()
    {
        $this->catalogSeo()->delete();
        foreach ($this->files as $file) {
            // dd(Storage::disk('public')->exists('files/'.$file->filename));
            Storage::disk('public')->delete('files/' . $file->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $file->filename);
            Storage::disk('public')->delete('files/1250x700/' . $file->filename);
            $file->delete();
        }
        //$this->files()->delete();

        parent::delete();
    }


}
