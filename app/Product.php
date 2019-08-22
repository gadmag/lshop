<?php

namespace App;

use App\Services\Cacheable;
use App\Services\TransliteratedService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\User;
use App\Alias;
use App\FieldOption;
use Illuminate\Database\Eloquent\Builder;
use App\Services\ProductFilter;

class Product extends Model
{
    use Sluggable;
    use ProductFilter;
    use Cacheable;

    protected $fillable = ['title', 'description',
        'model', 'sku', 'price', 'type', 'quantity', 'total_selling', 'sort_order', 'size', 'status',
        'material', 'alias', 'user_id'];


    protected $allowedFilters = [
        'id', 'material', 'color', 'productOptions.price', 'productOptions.color', 'productOptions.color_stone','catalogs.name'
    ];

    protected $orderable = [
        'id', 'title', 'price', 'created_at', 'weight', 'total_selling'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sort', function (Builder $builder) {
            $builder->orderBy('sort_order', 'asc')->latest('products.created_at');
        });

    }

    public function sluggable()
    {
        return [
            'alias' => [
                'source' => 'title'
            ]
        ];
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float)$value;
    }

    public function setWeightAttribute($value)
    {
        $this->attributes['weight'] = (float)$value;
    }

    public function getStatusAttribute($value)
    {
        if ($value == 1) return 'Включено';
        return 'Отключено';
    }

    public function getFieldOptions(string $type)
    {
        return FieldOption::whereType($type)->pluck('name', 'name')->all();
    }

    /**
     * @param $query
     */
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }



    /**
     * @param $query
     * @param string $value
     */
    public function scopeType($query, $value = 'product')
    {
        $query->where('type', $value);
    }

    /**
     * @param $query
     */
    public function scopeNotActive($query)
    {
        $query->where('status', 0);
    }

    /**
     * @param $query
     */
    public function scopeLargerQuantity($query)
    {
        $query->where('quantity', '>', 0);
    }


    /**
     * @return array
     */
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
        $this->productDiscount()->delete();
        $this->productSpecial()->delete();
        foreach ($this->files as $file) {
            // dd(Storage::disk('public')->exists('files/'.$file->filename));
            Storage::disk('public')->delete('files/' . $file->filename);
            Storage::disk('public')->delete('files/thumbnail/' . $file->filename);
            Storage::disk('public')->delete('files/600x450/' . $file->filename);
            Storage::disk('public')->delete('files/250x250/' . $file->filename);
            Storage::disk('public')->delete('files/90x110/' . $file->filename);
            $file->delete();
        }
        parent::delete();
    }

}
