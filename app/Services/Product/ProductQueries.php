<?php


namespace App\Services\Product;


use App\Catalog;
use App\Http\Controllers\Admin\UploadTrait;
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

    public function getByCatalogFilter(int $id = null)
    {
        if ($id) {
            $catalog = Catalog::published()->findOrFail($id);
            return $catalog->products()->active()->advancedFilter()
                ->paginate(request('limit', 12), ['products.id', 'products.updated_at']);
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

    public function getWishListProducts(array $ids): Collection
    {
        return Product::active()->whereIn('id', $ids)->get();
    }

    public function getProductsByIds(array $ids)
    {
        return Product::active()->with($this->relations)->whereIn('id', $ids)->get();
    }

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

        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, $this->imgResize, true);
        }

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        $product->services()->sync($request->input('service_list') ?: []);
        $product->save();
        return $product;
    }

    protected function updateProduct(Request $request, Product $product): Product
    {
        $product->update($request->all());

        if ($request->filled('productSeo')) {
            $product->productSeo()->update($request->productSeo);
        } else {
            $product->productSeo()->delete();
        }


        if ($request->filled('productSpecial.price')) {
            $special_id = isset($request->productSpecial['id']) ? $request->productSpecial['id'] : null;
            $product->productSpecial()->updateOrCreate(['id' => $special_id], $request->productSpecial);
        } else {
            $product->productSpecial()->delete();
        }

        if ($request->filled('productOptions')) {
            $this->updateOptions($request, $product);
        }


        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, $this->imgResize, true);
        }

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        $product->services()->sync($request->input('service_list') ?: []);
        $product->touch();
        return $product;
    }

    protected function createOptions(Request $request, $product): void
    {
        foreach ($request->extractOptions() as $optionAttr) {
            $option = Option::create($optionAttr);
            $option->discount()->create($optionAttr['discount']);
            if (!empty($optionAttr['image_option'])) {
                $this->multipleUpload($optionAttr['image_option'], $option, $this->imgResize, true);
            }
            $product->productOptions()->save($option);
            $product->sumOptionQty();
        }
    }

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
            if (!empty($optionAttr['image_option'])) {
                $this->multipleUpload($optionAttr['image_option'], $option, $this->imgResize, true);
            }
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