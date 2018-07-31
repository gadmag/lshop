<?php

namespace App;

use App\Service\TreeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Service\TransliteratedService;
use Carbon\Carbon;

/**
 * App\Catalog
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property int $status
 * @property int $user_id
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read \App\Seo $seoAttr
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog unpublished()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Catalog whereUserId($value)
 * @mixin \Eloquent
 */
class Catalog extends Model
{
    use TransliteratedService;

   protected $fillable = ['name', 'parent_id', 'description', 'alias' ,'status',  'user_id', 'type','order'];



    public function setAliasAttribute($alias)
    {
        if (!empty($alias)) {
            $this->attributes['alias'] = $this->transliterate($alias);
        } else {
            $this->attributes['alias'] = $this->transliterate($this->attributes['name']);
        }
    }

    public function scopePublished($query)
    {
        $query->where('status', 1);
    }

    public function scopeOrder($query)
    {
            $query->orderBy('order','ASC');
    }
    public function scopeUnpublished($query)
    {
        $query->where('status', 0);
    }

    public function scopeOfType($query,$type)
    {
        $query->where('type', $type);
    }


    public  function scopeExcludeSelf($query, $id)
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
        foreach ($this->files as $file)
        {
           // dd(Storage::disk('public')->exists('files/'.$file->filename));
            Storage::disk('public')->delete('files/'.$file->filename);
            Storage::disk('public')->delete('files/thumbnail/'.$file->filename);
            Storage::disk('public')->delete('files/1250x700/'.$file->filename);
            $file->delete();
        }
        //$this->files()->delete();

        parent::delete();
    }



}
