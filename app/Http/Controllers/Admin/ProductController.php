<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use App\Services\Product\BaseQueries;
use App\Services\TreeService;
use App\Upload;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use Gate;
use Carbon\Carbon;
use App\Product;
use App\Catalog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Image;
use File;

class ProductController extends Controller
{
    use TreeService;
    use UploadTrait;

    /**
     * @var BaseQueries
     */
    private $service;

    /**
     * ProductController constructor.
     * @param BaseQueries $service
     */
    public function __construct(BaseQueries $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $f = $request->get('f', []);
//        dd($f['title']);
        $title = !empty($f['title']) ? $f['title'] : null;
        $model = !empty($f['model']) ? $f['model'] : null;
        $group_by = !empty($f['order_by']) ? $f['order_by'] : "created_at";
        $group_dir = isset($f['order_dir']) ? $f['order_dir'] : "DESC";
        $products = Product::with('catalogs')->type('product')->orderBy($group_by, $group_dir);
        if ($title) {
            $products->where('title', 'like', '%' . $title . '%');
        }
        if ($model) {
            $products->where('model', 'like', '%' . $model . '%');
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
                'sortable' => true,
                'has_filters' => true,
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
                    return $value;
                }
            ])
            ->setColumn('quantity', 'Кол-во', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => false,
                'wrapper' => function ($value) {
                    return '<span class="badge badge-success">' . $value . '</span>';
                }
            ])
            // Setup action column
            ->setActionColumn([
                'attributes' => ['class' => 'text-right'],
                'wrapper' => function ($value, $row) {
                    return '<a style="display: inline-block" href="' . action('Admin\ProductController@edit', [$row->id]) . '" class="btn btn-info" title="Редактировать"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>
					 <form style="display: inline-block" action="' . url('/admin/products/' . $row->id) . '" method="POST">
                                    ' . csrf_field() . ' ' . method_field('DELETE') . '
                                    <button style="display: inline-block" type="submit" onclick="return confirm(\'Вы уверены?\')" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i> Удалить
                                    </button>
                                </form>';
                }
            ]);

        return view('AdminLTE.product.index')->with([
            'products' => $products,
            'grid' => $grid
        ]);
    }

    /**Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $services = Service::getByType('engraving')->get();
        $catalogs = self::getTree(Catalog::all());
        return view('AdminLTE.product.create', [
            'catalogs' => $catalogs,
            'services' => $services,
            'catalog' => ''
        ]);
    }

    /**Store a newly created resource in storage.
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $product = $this->service->create($request);

        return redirect()->route('products.index')->with([
            'flash_message' => "{$product->title} добавлена",
        ]);
    }


    /**Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $catalogs = self::getTree(Catalog::all());
        $services = Service::getByType('engraving')->get();
        return view('AdminLTE.product.edit', [
            'product' => $product,
            'catalogs' => $catalogs,
            'services' => $services,
        ]);
    }

    /**Update the specified resource in storage.
     * @param ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, int $id)
    {
        $product = $this->service->update($request, $id);
        return redirect()->route('products.index')->with([
            'flash_message' => "{$product->title} обновлена",
        ]);
    }

    public function uploadFiles(Request $request)
    {
        $uploads = $this->service->createUploads($request->file('files'));
        return ['uploads' => $uploads];
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $deletedProduct = $this->service->delete($id);
        return redirect()->route('products.index')->with([
            'flash_message' => "Продукт {$deletedProduct->alias} удален",
        ]);
    }

}
