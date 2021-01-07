<?php


namespace App\Services\Product;

use App\Product;
use App\Services\Filterable\ProductFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Carbon\Carbon;

class CacheProductQueries implements BaseQueries
{

    const CACHE_DURATION = 1;

    const CACHE_KEY = 'PRODUCT';

    /**
     * @var BlockQueries
     */
    private $base;

    /**
     * @var Repository
     */
    private $cache;


    /**
     * @var Carbon
     */
    private $duration;


    public function __construct(BaseQueries $base, Repository $cache)
    {
        $this->base = $base;
        $this->cache = $cache;
        $this->duration = Carbon::now()->addDays(self::CACHE_DURATION);
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getById(int $id): Product
    {
        $product = $this->base->getById($id);
        return $this->cache->remember($product->getCacheKey(),
            $this->duration,
            function () use ($product) {
                return $this->base->getRelationProduct($product);
            });
    }

    /** Get an items from cache or store value
     * @param string $id
     * @return Product
     */
    public function getByAlias(string $id): Product
    {
        $product = $this->base->getByAlias($id);
        return $this->cache->remember($product->getCacheKey(),
            $this->duration,
            function () use ($product) {
                return $this->base->getRelationProduct($product);
            });
    }

    /**
     * @param Request $request
     * @return Product
     */
    public function create(Request $request): Product
    {
        $product = $this->base->create($request);
        return $product;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Product
     */
    public function update(Request $request, int $id): Product
    {
        $product = $this->base->update($request, $id);
        return $product;

    }

    /**
     * Delete cache, return deleted product
     * @param int $id
     * @return Product
     */
    public function delete(int $id): Product
    {
        $deletedProduct = $this->base->delete($id);
        $this->cache->pull($deletedProduct->getCacheKey());
        return $deletedProduct;
    }


    public function getAllByCatalog(Product $product, int $limit = 4): Collection
    {
        $products = $this->base->getAllByCatalog($product, $limit);
        return $this->rememberMultiple($products);
    }

    public function getByCatalogFilter(int $id = null)
    {
        $products = $this->base->getByCatalogFilter($id);
        $list = $this->rememberMultiple($products->getCollection());
        $products->getCollection()->transform(function ($product, $key) use ($list) {
            return $list[$key];
        });
        return $products;
    }

    /**
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getNewProducts()
    {
        $products = $this->base->getNewProducts();
        return $this->rememberMultiple($products);
    }

    /**
     * @param int $limit
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getSpecialProducts(int $limit = 4): Collection
    {
        $products = $this->base->getSpecialProducts($limit);
        return $this->rememberMultiple($products);
    }


    public function getWishListProducts(array $ids): Collection
    {
        $products = $this->base->getWishListProducts($ids);
        return $this->rememberMultiple($products);
    }



    private function getCacheKey(string $key): string
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . "_{$key}";
    }

    /**
     * if cache exist return
     * @param Collection $items
     * @return Collection
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function rememberMultiple(Collection $items): Collection
    {
        $keys = $this->normalizeKeys($items);
        $getKeys = $this->cache->getMultiple(array_flip($keys));
        $setKeys = array_filter($getKeys, function ($item) {
            return is_int($item);
        });
        if (!$setKeys) {
            return collect(array_values($getKeys));
        }
        $list = [];
        $products = $this->base->getProductsByIds($setKeys);
        foreach ($products as $product) {
            $list[$product->getCacheKey()] = $product;
        }

        $this->cache->setMultiple($list, $this->duration);
        return collect(array_values(array_merge($getKeys, $list)));
    }


    /**
     * @param Collection $items
     * @return array
     */
    private function normalizeKeys(Collection $items): array
    {
        return $items->mapWithKeys(function ($item) {
            return [$item['id'] => $item->getCacheKey()];
        })->toArray();

    }

}