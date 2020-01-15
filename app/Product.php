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
use function Deployer\get;

class Product extends Model
{
    use Sluggable;
    use ProductFilter;
    use Cacheable;

    protected $fillable = ['title', 'description', 'model', 'price', 'type', 'quantity', 'total_selling', 'sort_order', 'size', 'status',
        'material', 'alias', 'user_id'];


    protected $allowedFilters = [
        'id', 'material', 'color', 'productOptions.price', 'productOptions.color', 'productOptions.color_stone', 'catalogs.name'
    ];

    protected $orderable = [
        'id', 'title', 'price', 'created_at', 'weight', 'total_selling'
    ];

    protected $imageResize = [
        '600x450' => array('width' => 500, 'height' => 500),
        '250x250' => array('width' => 260, 'height' => 260),
        '90x110' => array('width' => 110, 'height' => 110)
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
        return FieldOption::whereType($type)->order()->pluck('name', 'name')->all();
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


    public function getOptionsNotIds(array $ids)
    {
        return $this->productOptions()->whereNotIn('id', $ids)->get();
    }


    public function getOptionToArray($id)
    {
        return $this->productOptions()->find($id)->toArray();
    }

    public function getSeo(): Seo
    {
        return $this->productSeo()->first();
    }


    /** Check discount by option id
     * @param int $id
     * @return bool
     */
    public function isDiscount(int $id = null): bool
    {
        return $this->productOptions()->exists() && $this->productOptions()->find($id)->discount()->exists();
    }


    /** Get discount by option id
     * @param int $id
     * @return Discount
     */
    public function getDiscount(int $id = null): ?Discount
    {
        if ($this->isDiscount($id)) {
            return $this->productOptions()->find($id)->discount;
        }
        return null;
    }

    public function sumOptionQty(): void
    {
        if ($this->productOptions()->exists()) {
            $this->quantity =  $this->productOptions()->get()->sum(function (Option $option) {
                return $option->quantity;
            });
        }
    }


    private function isOptions()
    {
        return $this->productOptions()->exists();
    }

    private function isSpecial()
    {
        return $this->productSpecial()->isActive()->exists();
    }


    public function getSpecial(): ?Special
    {
        if ($this->isSpecial()) {
            return $this->productSpecial;
        }
        return null;
    }


    public function getSpecialPrice(int $id)
    {
        if ($this->productSpecial->price_prefix == '%') {
            return $this->getPrice($id) * intval($this->productSpecial->price) / 100;
        } else {
            return floatval($this->getPrice($id) - $this->productSpecial->price);
        }
    }


    /**
     * Get price product or option
     * @param int|null $id
     * @return float
     */
    public function getPrice(int $id = null): float
    {
        return $id ? $this->productOptions()->find($id)->price : $this->price;

    }


    /** Get weight option
     * @param int|null $id
     * @return mixed
     */
    public function getWeight(int $id = null)
    {
        return $id ? $this->productOptions()->find($id)->weight : 0;
    }


    /** Get color option
     * @param int|null $id
     * @return string
     */
    public function getColor(int $id = null)
    {
        return $id ? $this->productOptions()->find($id)->color : '';
    }


    /** Get color_stone option
     * @param int|null $id
     * @return string
     */
    public function getColorStone(int $id = null)
    {
        return $id ? $this->productOptions()->find($id)->color_stone : '';
    }


    /** Front product image
     * @param int $id
     * @return Model|\Illuminate\Database\Eloquent\Relations\MorphMany|object|string|null
     */
    public function frontImg(int $id = null)
    {
        if ($this->files()->exists()) {
            return $this->files()->first()->filename;
        } elseif ($this->productOptions()->find($id) && $this->productOptions()->find($id)->files()->exists()) {
            return $this->productOptions()->find($id)->files()->first()->filename;
        }

        return '';
    }

}
