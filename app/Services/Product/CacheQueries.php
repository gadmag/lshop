<?php


namespace App\Services\Product;


use App\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Cache\Repository;
use Carbon\Carbon;

class CacheQueries implements BaseQueries
{

    const CACHE_DURATION = 10;
    const CACHE_KEY = 'PRODUCT';

    /**
     * @var ProductQueries
     */
    private $base;

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(BaseQueries $base, Repository $cache)
    {
        $this->base = $base;
        $this->cache = $cache;
    }

    public function getById(int $id): Product
    {
        $key = "id_{$id}";
        $cacheKey = $this->getCacheKey($key);
        return $this->cache->remember($cacheKey,
            self::CACHE_DURATION,
            function () use ($id) {
                return $this->base->getById($id);
            });
    }

    public function getByAlias(string $id): Product
    {
        $key = "alias_{$id}";
        $cacheKey = $this->getCacheKey($key);
        return $this->cache->remember($cacheKey,
            self::CACHE_DURATION,
            function () use ($id) {
                return $this->base->getByAlias($id);
            });
    }

    public function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public function getAllByCatalog(Product $product, int $limit = 4): Collection
    {
        $catalogId = $product->catalogs()->exists() ? $product->catalogs()->first()->id : null;
        $key = "getProductByCatalog_{$catalogId}";
        $cacheKey = $this->getCacheKey($key);
        return $this->cache->remember($cacheKey,
            self::CACHE_DURATION,
            function () use ($product, $limit) {
                return $this->base->getAllByCatalog($product, $limit);
            });
    }

    public function getJsonByCatalogFilter(int $id = null): LengthAwarePaginator
    {
        $key = "getJsonByCatalogFilter_{$id}";
        $cacheKey = $this->getCacheKey($key);
        return $this->cache->remember($cacheKey,
            self::CACHE_DURATION,
            function () use ($id) {
                return $this->base->getJsonByCatalogFilter($id);
            });
    }

    public function getCacheKey(string $key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . "_{$key}";
    }
}