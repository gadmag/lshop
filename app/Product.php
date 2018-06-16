<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\User;
use App\Alias;
use App\Seo;

/**
 * App\Product
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $code
 * @property string $alias
 * @property int $status
 * @property int $user_id
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Catalog[] $catalogs
 * @property-read \App\Seo $seoAttr
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product unpublished()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = ['title', 'trade_price', 'retail_price', 'description',
                        'model', 'sku', 'quantity', 'weight', 'size', 'status',
                        'material','coating','color_stone','user_id', 'published_at'];
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

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    /** Seo аттрибуты продукта
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCatalogListAttribute()
    {

        return $this->catalogs->pluck('id')->all();
    }

    /**
     * Получить  пользователя продукта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productUser()
    {
        return $this->belongsTo('App\User');
    }

    public function productSeo()
    {

        return $this->morphMany('App\Seo', 'seostable');
    }

    /**
     * Пулучиь категории для данного продукта
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function catalogs()
    {
        // return $this->belongsToMany('App\Catalog', 'product_catalog','product_id', 'catalog_id')->withTimestamps();
        return $this->morphToMany('App\Catalog', 'cataloggable');
    }

    public function alias()
    {

        return $this->morphOne('App\Alias', 'aliastable');
    }

    /**
     * Получить файлы продуктов
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany('App\Upload', 'uploadstable');
    }

    function delete()
    {
        $this->alias()->delete();
        $this->seoAttr()->delete();
        foreach ($this->files as $file) {
            // dd(Storage::disk('public')->exists('files/'.$file->filename));
            Storage::disk('public')->delete('files/' . $file->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $file->filename);
            Storage::disk('public')->delete('files/600x450/' . $file->filename);
            Storage::disk('public')->delete('files/400x300/' . $file->filename);
            $file->delete();
        }


        parent::delete();
    }

}
