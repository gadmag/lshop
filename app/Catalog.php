<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
   protected $fillable = ['name', 'description', 'alias' ,'status',  'user_id', 'type', 'published_at'];

    //    const CREATED_AT = null;
    protected $dates = ['published_at'];

    public function setPublishedAtAttribute($date)
    {
        //dd($date);
        // $this->attributes['published_at'] = Carbon::createFromFormat('d.m.Y', $date);

        $this->attributes['published_at'] = Carbon::parse($date);
    }

    public function getPublishedAtAttribute($date)
    {
//       dd($date);
        return Carbon::parse($date)->format('d.m.Y H:i');
    }

    public function scopePublished($query)
    {
        $query->where('status', 1);
    }

    public function scopeUnpublished($query)
    {
        $query->where('status', 0);
    }

    public function scopeOfType($query,$type)
    {
        $query->where('type', $type);
    }


    /** Список статей категории
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
   public function products()
    {

       // return $this->belongsToMany('App\Product', 'product_catalog','catalog_id','product_id')->withTimestamps();
        return $this->morphedByMany('App\Product', 'cataloggable');

    }

    public function articles()
    {

        // return $this->belongsToMany('App\Product', 'product_catalog','catalog_id','product_id')->withTimestamps();
        return $this->morphedByMany('App\Articles', 'cataloggable')->published()->ofType('news')->latest();

    }

    /** Seo аттрибуты продуста
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seoAttr()
    {

        // return $this->hasOne('App\Seo', 'article_id', 'id');
        return $this->morphOne('App\Seo', 'seotable');
    }

    public function alias()
    {

        return $this->morphOne('App\Alias', 'aliastable');
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
        $this->alias()->delete();
        $this->seoAttr()->delete();
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
