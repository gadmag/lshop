<?php

namespace App;

use App\Service\TreeService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Service\TransliteratedService;
use Carbon\Carbon;

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


    /** Список статей категории
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {

        // return $this->belongsToMany('App\Product', 'product_catalog','catalog_id','product_id')->withTimestamps();
        return $this->morphedByMany('App\Product', 'cataloggable');

    }

    public function catalogMenu()
    {
        return $this->morphOne('App\Menu', 'menu_linktable');
    }

    /** Seo аттрибуты продуста
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
