<?php


namespace App\Services\Product;


use App\Http\Controllers\Admin\UploadTrait;
use App\Filters\ProductFilter;
use Illuminate\Http\Request;
use App\Option;
use App\Product;
use App\Services\TreeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductQueries implements BaseQueries
{
    use TreeService;
    use UploadTrait;

    private $relations = [
        'productOptions',
        'productOptions.files',
        'productOptions.discount',
        'productSpecial',
        'catalogs',
        'files',
        'services',

    ];

    private $imgResize = [
        '600x450' => array('width' => 500, 'height' => 500),
        '250x250' => array('width' => 260, 'height' => 260),
        '90x110' => array('width' => 110, 'height' => 110)
    ];

    private $filter;

    public function __construct(ProductFilter $filter)
    {
        $this->filter = $filter;
    }

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

    public function create(Request $request): Product
    {
        return $this->createProduct($request);
    }

    /** Update product by id
     * @param Request $request
     * @param int $id
     * @return Product
     */
    public function update(Request $request, int $id): Product
    {
        $product = Product::with($this->relations)->findOrFail($id);
        return $this->updateProduct($request, $product);
    }


    /** Delete product by id
     * @param int $id
     * @return Product
     */
    public function delete(int $id): Product
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

    /**
     * Get products by catalog id
     * @param int|null $id
     * @return mixed
     */
    public function getByCatalogFilter(int $id = null)
    {
        if ($id) {
         return   Product::active()->whereHas('catalogs', function ($query) use ($id) {
                $query->published()->whereId($id);
            })->advancedFilter($this->filter)
                ->paginate(request('limit', 12), ['id', 'updated_at']);
        }



        return Product::active()->advancedFilter($this->filter)
            ->paginate(request('limit', 12), ['products.id', 'products.updated_at']);
    }

    /**
     * Get new product ids
     * @return mixed
     */
    public function getNewProducts()
    {
        return Product::active()->orderBy('sort_order', 'asc')->latest()->take(8)->get(['id', 'updated_at']);
    }


    /**
     * Get special products
     * @param int $limit
     * @return mixed
     */
    public function getSpecialProducts(int $limit = 4)
    {
        return Product::whereHas('productSpecial', function ($item) {
            return $item->isActive();
        })->active()->orderBy('sort_order', 'asc')->latest()->take($limit)->get();
    }


    /**
     * @param array $ids
     * @return Collection
     */
    public function getWishListProducts(array $ids): Collection
    {
        return Product::active()->whereIn('id', $ids)->get();
    }


    /**
     * @param array $ids
     * @return mixed
     */
    public function getProductsByIds(array $ids)
    {
        return Product::active()->with($this->relations)->whereIn('id', $ids)->get();
    }


    /**
     * @param Request $request
     * @return Product
     */
    protected function createProduct(Request $request): Product
    {
        $product = Auth::user()->products()->create($request->all());

        if ($request->filled('productSeo')) {
            $product->productSeo()->create($request->productSeo);
        }

        if ($request->filled('productSpecial.price')) {
            $product->productSpecial()->create($request->productSpecial);

        }

        if ($request->filled('productOptions')) {
            $this->createOptions($request, $product);

        }

        if ($request->exists('productUpload')) {
            $product->syncUploads(explode(',', $request->productUpload));

        }

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        $product->services()->sync($request->input('service_list') ?: []);
        $product->save();
        return $product;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Product
     */
    protected function updateProduct(Request $request, Product $product): Product
    {
        $product->update($request->all());

        if ($request->filled('productSeo')) {
            $product->productSeo()->update($request->productSeo);
        } else {
            $product->productSeo()->delete();
        }


        if ($request->filled('productSpecial.price')) {
            $special_id = $request->productSpecial['id'] ?? null;
            $product->productSpecial()->updateOrCreate(['id' => $special_id], $request->productSpecial);
        } else {
            $product->productSpecial()->delete();
        }

        if ($request->filled('productOptions')) {
            $this->updateOptions($request, $product);
        }

        if ($request->exists('productUpload')) {
            $product->syncUploads(explode(',', $request->productUpload));
        }

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        $product->services()->sync($request->input('service_list') ?: []);
        $product->touch();
        return $product;
    }


    /**
     * @param Request $request
     * @param $product
     */
    protected function createOptions(Request $request, $product): void
    {
        foreach ($request->extractOptions() as $optionAttr) {
            $option = Option::create($optionAttr);
            $option->discount()->create($optionAttr['discount']);
            if (!empty($optionAttr['optionUpload'])) {
                $option->syncUploads(explode(',', $optionAttr['optionUpload']));
            }
            $product->productOptions()->save($option);
            $product->sumOptionQty();
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     */
    protected function updateOptions(Request $request, Product $product): void
    {

        $ids = array_map(function ($item) {
            return $item['id'];
        }, $request->extractOptions());
        $this->deleteOptions($product->getOptionsNotIds($ids));
        foreach ($request->extractOptions() as $optionAttr) {
            $id = $product->productOptions()->updateOrCreate(['id' => $optionAttr['id']], $optionAttr)->id;
            $option = Option::whereId($id)->first();
            $this->updateDiscount($option, $optionAttr['discount']);
            $option->syncUploads(explode(',', $optionAttr['optionUpload']));
        }
    }


    protected function syncCatalogs(Product $product, array $catalogs): void
    {
        $product->catalogs()->sync($catalogs);
    }

    protected function updateDiscount(Option $option, array $attributes): void
    {
        if ($attributes['price'] || $attributes['quantity']) {
            $option->discount()->updateOrCreate(['id' => $attributes['id']], $attributes);
        } else {
            $option->discount()->delete();
        }

    }

    protected function deleteOptions($options)
    {
        foreach ($options as $option) {
            $option->delete();
        }
    }


}