<?php


namespace App\Services\Product;


use App\Catalog;
use App\Http\Controllers\Admin\UploadTrait;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Option;
use App\Product;
use App\Services\TreeService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductQueries implements BaseQueries
{
    use TreeService;
    use UploadTrait;

    private $relations = [
        'productOptions',
        'productOptions.files',
        'productSpecial',
        'catalogs',
        'productDiscount',
        'files'
    ];

    private $imgResize = [
        '600x450' => array('width' => 500, 'height' => 500),
        '250x250' => array('width' => 260, 'height' => 260),
        '90x110' => array('width' => 110, 'height' => 110)
    ];


    public function getById(int $id): Product
    {
        return Product::active()->findOrFail($id);
    }

    public function getByAlias(string $id): Product
    {
        return Product::active()->whereAlias($id)->firstOrFail();
    }

    /** Load relation product model
     * @param Product $product
     * @return mixed
     */
    public function getRelationProduct(Product $product)
    {
        return $product->load($this->relations);
    }

    public function create(ProductRequest $request): Product
    {
        return $this->createProduct($request);
    }

    public function update(ProductRequest $request, int $id): Product
    {
        $product = Product::with($this->relations)->findOrFail($id);
        return $this->updateProduct($request, $product);
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $deletedProduct = $product;
        $product->delete();
        return $deletedProduct;
    }


    public function getAllByCatalog(Product $product, int $limit = 4): Collection
    {
        $catalog = $product->catalogs()->exists() ? $product->catalogs()->first() : null;
        if (!$catalog) {
            return Product::active()->get(['id', 'updated_at'])->except($product->id)->take($limit);
        }
        return $catalog->products()->active()->get()->except($product->id)->take($limit);
    }

    public function getByCatalogFilter(int $id = null)
    {
        if ($id) {
            $catalog = Catalog::published()->findOrFail($id);
            return $catalog->products()->active()->advancedFilter()
                ->paginate(request('limit', 12), ['id', 'updated_at']);
        }
        return Product::active()
            ->advancedFilter()->paginate(request('limit', 12), ['id', 'updated_at']);
    }

    public function getNewProducts()
    {
        return Product::active()->take(8)->get(['id', 'updated_at']);
    }

    public function getSpecialProducts(int $limit = 4)
    {
        return Product::has('productSpecial')->active()->take($limit)->get();
    }

    public function getProductsByIds(array $ids)
    {
        return Product::active()->with($this->relations)->whereIn('id', $ids)->get();
    }

    protected function createProduct(ProductRequest $request): Product
    {

        $product = Auth::user()->products()->create($request->all());

        if ($request->filled('productSeo')) {
            $product->productSeo()->create($request->productSeo);
        }

        if ($request->filled('productDiscount.price') || $request->filled('productDiscount.quantity')) {
            $product->productDiscount()->create($request->productDiscount);
        }

        if ($request->filled('productSpecial.price')) {
            $product->productSpecial()->create($request->productSpecial);
        }

        if ($request->filled('productOptions')) {
            $this->createMultipleOptions($request, $product);
        }
        if ($product->productOptions()->exists()) {
            $this->updateQuantity($product);
        }
        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, $this->imgResize, true);
        }

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        return $product;
    }

    protected function updateProduct(ProductRequest $request, Product $product): Product
    {
        $product->update($request->all());

        if ($request->filled('productSeo')) {
            $product->productSeo()->update($request->productSeo);
        } else {
            $product->productSeo()->delete();
        }

        if ($request->filled('productDiscount.price') || $request->filled('productDiscount.quantity')) {
            $discount_id = isset($request->productDiscount['id']) ? $request->productDiscount['id'] : null;
            $product->productDiscount()->updateOrCreate(['id' => $discount_id], $request->productDiscount);
        } else {
            $product->productDiscount()->delete();
        }

        if ($request->filled('productSpecial.price')) {
            $special_id = isset($request->productSpecial['id']) ? $request->productSpecial['id'] : null;
            $product->productSpecial()->updateOrCreate(['id' => $special_id], $request->productSpecial);
        } else {
            $product->productSpecial()->delete();
        }

        if ($request->filled('productOptions')) {
            $this->updateMultipleOptions($request, $product);
        }

        if ($product->productOptions()->exists()) {
            $this->updateQuantity($product);
        }

        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, $this->imgResize, true);
        }
        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        $product->touch();
        return $product;
    }

    protected function createMultipleOptions(ProductRequest $request, $product): void
    {
        foreach ($request->extractOptions() as $optionAttr) {
            $option = Option::create($optionAttr);
            if (!empty($optionAttr['image_option'])) {
                $this->multipleUpload([$optionAttr['image_option']], $option, $this->imgResize, true);
            }
            $product->productOptions()->save($option);
        }
    }

    protected function updateMultipleOptions(ProductRequest $request, Product $product): void
    {
        $output = array_map(function ($item) {
            return $item['id'];
        }, $request->extractOptions());
        $product->productOptions()->whereNotIn('id', $output)->delete();
        foreach ($request->extractOptions() as $optionAttr) {
            $id = $product->productOptions()->updateOrCreate(['id' => $optionAttr['id']], $optionAttr)->id;
            $option = Option::whereId($id)->first();
            if (!empty($optionAttr['image_option'])) {
                $this->multipleUpload([$optionAttr['image_option']], $option, $this->imgResize, true);
            }
        }
    }

    protected function syncCatalogs(Product $product, array $catalogs): void
    {
        $product->catalogs()->sync($catalogs);
    }

    protected function updateQuantity(Product $product): void
    {
        $sum_quantity = 0;
        foreach ($product->productOptions as $option) {
            $sum_quantity += $option->quantity;
        }
        $product->quantity = $sum_quantity;
        $product->save();
    }
}