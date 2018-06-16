<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
//        abort(403, 'Unauthorized action');
//        echo($user->name);


        if (Gate::denies('create-post', Product::class)) {
            abort(403, 'Unauthorized action');

        }

        $catalogs = Catalog::pluck('name', 'id');
        return view('AdminLTE.product.create', compact('catalogs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

       $product = $this->createProduct($request);


        //session()->flash('flash_message', 'Ваша статья добавленна');
        // session()->flash('flash_message_important', true);
        return  redirect("admin/products")->with([
            'flash_message'               =>   "{$product->title} добавлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (Gate::denies('update-post', $product)) {
            abort(403, 'Unauthorized action');

        }
        //$productType = ArticleType::OfArticleType($type)->firstOrFail();
        $catalogs = Catalog::pluck('name', 'id');


        return view('AdminLTE.product.edit', compact('product', 'catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         $product->update($request->except('seoAttr'));

        if ($request->has('seoAttr')) {
            $this->updateSeoAttr($request, $product);
        }
        if ($request->has('alias')) {
            $this->updateAliasAttr($request, $product);
        }

        $this->multipleUpload($request, $product,[
            '600x450' => array(
                'width' => 600,
                'height' => 450
            ),
            '400x300' => array(
                'width' => 400,
                'height' => 300
            )
        ]);
        $this->syncCatalogs($product, $request->input('catalog_list')? : []);

        return redirect("admin/products")->with([
            'flash_message'               =>   "{$product->title} обновлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       
        $product->delete();
        return redirect("admin/product")->with([
            'flash_message'               =>   "'{$product->title}' продукт удален",
//          'flash_message_important'     => true
        ]);
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
     */
    private function createProduct(Request $request)
    {
        $this->validate($request, ['title' => 'required|min:3']);

        $seo = $request->only('seoAttr');
        $alias_url = $request->only('alias.alias_url');

        $product = Auth::user()->products()->create($request->except('seoAttr','alias'));

        $this->multipleUpload($request, $product,[
            '600x450' => array(
            'width' => 600,
            'height' => 450
            ),
            '400x300' => array(
                'width' => 400,
                'height' => 300
            )
        ]);

        if (!empty($seo['seoAttr']))
        {

            $seo_attr = new Seo($seo['seoAttr']);
            $product->seoAttr()->save($seo_attr);
        }

        if ($request->has('alias'))
        {
            $alias = new Alias($alias_url['alias']);
            $product->alias()->save($alias);
        }

        $this->syncCatalogs($product,$request->input('catalog_list')? : []);

        return $product;

    }


    /** Обновление seo атрибутов продукта
     * @param Request $request
     * @param $id
     */
    protected function updateAliasAttr(Request $request, $product)

    {

        $this->validate($request, [
            'alias.alias_url' => 'min:3|unique:aliases,alias_url,' . $product->alias->id
        ]);

        $product->alias()->update($request->input('alias'));

    }

    /** Обновление seo атрибутов продукта
     * @param Request $request
     * @param $id
     */
    protected function updateSeoAttr(Request $request, $id)

    {
        $this->validate($request, ['seoAttr.title_seo' => 'min:3', 'seoAttr.keywords' => 'min:3', 'seoAttr.description' => 'min:3']);

        $seo_attr = Seo::firstOrCreate(['seotable_id' => $id]);

        $seo_attr->update($request->only('seoAttr')['seoAttr']);


    }
}
