<?php


namespace App\Services\Product;

use App\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseQueries
{

    public function getById(int $id): Product;
    public function getByAlias(string $id): Product;
    public function all(): Collection;
    public function getAllByCatalog(Product $product, int $limit): Collection;
    public function getJsonByCatalogFilter(int $id): LengthAwarePaginator;


}