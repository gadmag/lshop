<?php

namespace App\Http\Controllers\Admin;

use App\Services\TreeService;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\Product;
use App\Catalog;
use Validator;
use Image;
use File;

class ServiceController extends Controller
{
    use TreeService;
    use UploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $f = $request->get('f', []);
        $title = isset($f['title']) ? $f['title'] : null;
        $group_by = !empty($f['order_by']) ? $f['order_by'] : "created_at";
        $group_dir = isset($f['order_dir']) ? $f['order_dir'] : "DESC";
        $products = Product::with('catalogs')->type('service')->orderBy($group_by, $group_dir);
        if ($title) {
            $products->where('title', 'like', '%' . $title . '%');
        }

        $grid = new \Datagrid($products->paginate(10), $f);

        $grid
            ->setColumn('title', 'Заголовок', [
                'attributes' => ['class' => 'table-text'],
                // Will be sortable column
                'sortable' => true,
                // Will have filter
                'has_filters' => true
            ])
            ->setColumn('model', 'Модель', [
                'attributes' => ['class' => 'table-text'],
//                'sortable' => true,
                'has_filters' => true,
                // Wrapper closure will accept two params
                // $value is the actual cell value
                // $row are the all values for this row
//                'wrapper'     => function ($value, $row) {
//                    return '<a href="mailto:' . $value . '">' . $value . '</a>';
//                }
            ])
            ->setColumn('created_at', 'Дата добавления', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => false,
                'wrapper' => function ($value, $row) {
                    // The value here is still Carbon instance, so you can format it using the Carbon methods
                    return $value;
                }
            ])
            ->setColumn('status', 'Статус', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => false,
                'wrapper' => function ($value, $row) {
                    // The value here is still Carbon instance, so you can format it using the Carbon methods
                    return $value;
                }
            ])
            ->setColumn('quantity', 'Кол-во', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => false,
                'wrapper' => function ($value){
                    return '<span class="label label-success">'.$value.'</span>';
                }
            ])
            // Setup action column
            ->setActionColumn([
                'attributes' => ['class' => 'text-right'],
                'wrapper' => function ($value, $row) {
                    return '<a style="display: inline-block" href="' . action('Admin\ServiceController@edit', [$row->id]) . '" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>
					 <form style="display: inline-block" action="' . url('/admin/services/' . $row->id) . '" method="POST">
                                    ' . csrf_field() . ' ' . method_field('DELETE') . '
                                    <button style="display: inline-block" type="submit" onclick="return confirm(\'Вы уверены?\')" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i> Удалить
                                    </button>
                                </form>';
                }
            ]);

        return view('AdminLTE.service.index')->with([
            'products' => $products,
            'grid' => $grid
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

        $catalogs = self::getTree(Catalog::all());
        return view('AdminLTE.service.create', [
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
    public function store(ServiceRequest $request)
    {
        $product = $this->createProduct($request);
        $product->type = 'service';
        $product->save();
        return redirect("admin/services")->with([
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
        $product = Product::type('service')->findOrFail($id);
        $catalogs = self::getTree(Catalog::all());
        return view('AdminLTE.service.edit', [
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
    public function update(ServiceRequest $request, $id)
    {
        $product = Product::type('service')->findOrFail($id);
        $product = $this->updateProduct($request, $product);
        $product->type = 'service';
        $product->save();
        return redirect("admin/services")->with([
            'flash_message' => "{$product->title} обновлена",
//          'flash_message_important'     => true
        ]);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = Product::type('service')->findOrFail($id);
        $title = $product->title;
        $product->delete();
        return redirect("admin/services")->with([
            'flash_message' => "'{$title}' услуга удалена",
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
     * @return mixed
     */
    private function createProduct(Request $request)
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


        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, [
                '600x450' => array(
                    'width' => 500,
                    'height' => 500
                ),

                '250x250' => array(
                    'width' => 260,
                    'height' => 260
                ),

                '90x110' => array(
                    'width' => 110,
                    'height' => 110
                )
            ], true);
        }


        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);
        return $product;
    }

    private function updateProduct(Request $request, $product)
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


        if ($request->file('images')) {
            $this->multipleUpload($request->file('images'), $product, [
                '600x450' => array(
                    'width' => 500,
                    'height' => 500
                ),
                '250x250' => array(
                    'width' => 260,
                    'height' => 260
                ),
                '90x110' => array(
                    'width' => 110,
                    'height' => 110
                )
            ], true);
        }


        $this->syncCatalogs($product, $request->input('catalog_list') ?: []);

        return $product;

    }



}
