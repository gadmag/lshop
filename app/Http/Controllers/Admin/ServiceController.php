<?php

namespace App\Http\Controllers\Admin;

use App\Services\Product\BaseQueries;
use App\Services\TreeService;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Product;
use App\Catalog;

class ServiceController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $catalogs = self::getTree(Catalog::all());
        return view('AdminLTE.service.create', [
            'catalogs' => $catalogs,
            'catalog' => ''
        ]);
    }

    /** Store a newly created resource in storage.
     * @param ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
        $product = $this->service->create($request);
        $product->type = 'service';
        $product->save();
        return redirect("admin/services")->with([
            'flash_message' => "{$product->title} добавлена",
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
     * @param ServiceRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, $id)
    {
        $product = $this->service->update($request, $id);
        $product->type = 'service';
        $product->save();
        return redirect("admin/services")->with([
            'flash_message' => "{$product->title} обновлена",
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deletedProduct = $this->service->delete($id);
        return redirect("admin/services")->with([
            'flash_message' => "'{$deletedProduct->title}' услуга удалена",
        ]);
    }



}
