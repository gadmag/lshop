<?php


namespace App\Services\Product;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Collection;

interface BaseQueries
{

    public function getById(int $id): Product;

    public function getByAlias(string $id): Product;

    public function create(Request $request): Product;

    public function update(Request $request, int $id): Product;

    public function delete(int $id);

    public function getAllByCatalog(Product $product, int $limit): Collection;

    public function getByCatalogFilter(int $id);

    public function getWishListProducts(array $ids):Collection;


}