<?php

namespace App;

use App\Service\TransliteratedService;
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
    use TransliteratedService;

    protected $fillable = ['title', 'price', 'description',
                        'model', 'sku', 'quantity', 'weight', 'size', 'status',
                        'material','coating','alias','user_id'];


    public function setAliasAttribute($alias)
    {
        if (!empty($alias)) {
            $this->attributes['alias'] = $this->transliterate($alias);
        } else {
            $this->attributes['alias'] = $this->transliterate($this->attributes['title']);
        }
    }

    public function getUrlAliasAttribute()
    {
        return $this->attributes['alias']."-".$this->attributes['id'];
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }

    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = (int)$value;
    }


    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public static function isAliasExist($alias,$id) {
        if (static::query()->where('id', $id)->first()){
            return false;
        }
        $aliasProduct = static::query()->where('alias', $alias)->first();
        if ($aliasProduct) {
            return true;
        }
        return false;
    }

    public function getCatalogListAttribute()
    {

        return $this->catalogs->pluck('id')->all();
    }

    public function productDiscount()
    {
        return $this->hasOne('App\Discount');
    }

    public function productSpecial()
    {
        return $this->hasOne('App\Special');
    }

    public function productOptions()
    {
        return $this->hasMany('App\Option');
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
        return $this->morphToMany('App\Catalog', 'cataloggable');
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
        $this->productSeo()->delete();
        $this->productOptions()->delete();
        $this->productDiscount()->delete();
        $this->productSpecial()->delete();
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
