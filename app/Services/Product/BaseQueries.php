<?php


namespace App\Services\Product;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseQueries
{

    public function getById(int $id): Product;
    public function getByAlias(string $id): Product;
    public function create(ProductRequest $request): Product;
    public function update(ProductRequest $request, int $id): Product;
    public function delete(int $id);
    public function getAllByCatalog(Product $product, int $limit): Collection;
    public function getByCatalogFilter(int $id);


}