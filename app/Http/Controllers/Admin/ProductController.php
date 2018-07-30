<?php

namespace App\Http\Controllers\Admin;

use App\Option;
use App\Service\TreeService;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Gate;
use Carbon\Carbon;

use App\Product;
use App\Seo;
use App\Catalog;
use App\Alias;

use Validator;
use Image;
use File;

class ProductController extends Controller
{
    use TreeService;
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::latest('created_at')->paginate(10);


        return view('AdminLTE.product.index')->with([
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if (Gate::denies('create-post', Product::class)) {
            abort(403, 'Unauthorized action');

        }

        // $catalogs = Catalog::pluck('name', 'id');
        $catalogs = self::getTree(Catalog::all());
//        $catalogs = self::getSelectItem(Catalog::all());
//        dd($catalogs);
        return view('AdminLTE.product.create', [
            'catalogs' => $catalogs,
            'catalog' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $this->createProduct($request);

        return redirect("admin/products")->with([
            'flash_message' => "{$product->title} добавлена",
//          'flash_message_important'     => true
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $catalogs = self::getTree(Catalog::all());
        return view('AdminLTE.product.edit', [
            'product' => $product,
            'catalogs' => $catalogs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->updateProduct($request, $product);

        return redirect("admin/products")->with([
            'flash_message' => "{$product->title} обновлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return redirect("admin/products")->with([
            'flash_message' => "'{$product->title}' продукт удален",
//          'flash_message_important'     => true
        ]);
    }

    public function deleteOption($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return response(['status' => 'Delete option success']);
    }

    /** Синхронизация категорий продукта
     * @param Product $product
     * @param array $catalogs
     */
    private function syncCatalogs(Product $product, array $catalogs)
    {
        $product->catalogs()->sync($catalogs);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    private function createProduct(Request $request)
    {

        $product = Auth::user()->products()->create($request->all());

        if ($request->has('productSeo')) {
            $product->productSeo()->create($request->productSeo);
        }

        if ($request->has('productDiscount.price') || $request->has('productDiscount.quantity')) {
            $product->productDiscount()->create($request->productDiscount);
        }

        if ($request->has('productSpecial.price')) {
            $product->productSpecial()->create($request->productSpecial);
        }

        if ($request->has('productOptions')) {
            $this->createMultipleOptions($request, $product);
        }

        $this->multipleUpload($request, $product, [
            '600x450' => array(
                'width' => 600,
                'height' => 450
            ),

            '250x250' => array(
                'width' => 280,
                'height' => 280
            ),

            '90x110' => array(
                'width' => 90,
                'height' => 110
            )
        ]);

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);

        return $product;

    }

    private function updateProduct(Request $request, $product)
    {
        $product->update($request->all());

        if ($request->has('productSeo')) {
            $product->productSeo()->update($request->productSeo);
        } else {
            $product->productSeo()->delete();
        }

        if ($request->has('productDiscount.price') || $request->has('productDiscount.quantity')) {
            $discount_id = isset($request->productDiscount['id']) ? $request->productDiscount['id'] : null;
            $product->productDiscount()->updateOrCreate(['id' => $discount_id], $request->productDiscount);
        } else {
            $product->productDiscount()->delete();
        }

        if ($request->has('productSpecial.price')) {
            $special_id = isset($request->productSpecial['id']) ? $request->productSpecial['id'] : null;
            $product->productSpecial()->updateOrCreate(['id' => $special_id], $request->productSpecial);
        } else {
            $product->productSpecial()->delete();
        }

        if ($request->has('productOptions')) {
            $this->updateMultipleOptions($request, $product);
        }


        $this->multipleUpload($request, $product, [
            '600x450' => array(
                'width' => 250,
                'height' => 300
            ),
            '250x250' => array(
                'width' => 280,
                'height' => 280
            ),
            '90x110' => array(
                'width' => 90,
                'height' => 110
            )
        ]);

        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);

        return $product;

    }


    protected function createMultipleOptions(Request $request, $product)
    {
        $options = $request->extractOptions();

        foreach ($options as $optionAttr) {
            $option = Option::create($optionAttr);
            $product->productOptions()->save($option);
        }

    }

    protected function updateMultipleOptions(Request $request, Product $product)
    {
        $options = collect($request->extractOptions());
        foreach ($options as $optionAttr) {
            $product->productOptions()->updateOrCreate(['id' => $optionAttr['id']], $optionAttr);
        }
    }
}
