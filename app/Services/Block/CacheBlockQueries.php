<?php


namespace App\Services\Block;


use App\Block;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class CacheBlockQueries implements BlockService
{

    const CACHE_DURATION = 1;
    const CACHE_KEY = 'BLOCK';

    /**
     * @var ProductQueries
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

    public function __construct(BlockService $base, Repository $cache)
    {
        $this->base = $base;
        $this->cache = $cache;
        $this->duration = Carbon::now()->addWeek(self::CACHE_DURATION);

    }


    public function getAll(): Collection
    {
        $key = "list";
        $cacheKey = $this->getCacheKey($key);
        return $this->cache->remember($cacheKey,
            self::CACHE_DURATION,
            function () {
                return $this->base->getAll();
            });
    }

    public function create(array $params): void
    {
        $this->cache->pull($this->getCacheKey('list'));
        $this->base->create($params);
    }

    public function update(array $params, int $id): Block
    {
        $this->cache->pull($this->getCacheKey('list'));
        return $this->base->update($params, $id);
    }

    public function delete(int $id): string
    {
        $this->cache->pull($this->getCacheKey('list'));
        return $this->base->delete($id);
    }

    protected function getCacheKey(string $key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . "_{$key}";
    }
}