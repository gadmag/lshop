<?php


namespace App\Services\Product;


use App\Catalog;
use App\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductQueries implements BaseQueries
{
    private $relations = [
        'productOptions',
        'productOptions.files',
        'productSpecial',
        'productDiscount',
        'files'
    ];

    public function getById(int $id): Product
    {
        return Product::active()->with($this->relations)->findOrFail($id);
    }

    public function getByAlias(string $id): Product
    {
        return Product::active()->with($this->relations)->whereAlias($id)->firstOrFail();
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function getAllByCatalog(Product $product, int $limit = 4): Collection
    {
        $catalog = $product->catalogs()->exists() ? $product->catalogs()->first() : null;
        return $catalog->products()->active()->with($this->relations)->get()->except($product->id)->take($limit);
    }

    public function getJsonByCatalogFilter(int $id = null): LengthAwarePaginator
    {
        if ($id) {
            $catalog = Catalog::published()->findOrFail($id);
            return $catalog->products()->with($this->relations)->active()->advancedFilter();
        }
        return Product::with($this->relations)->active()->advancedFilter();
    }

}