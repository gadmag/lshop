<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $grid = $this->getGrid($request);
        return view('AdminLTE.order.index', [
            'grid' => $grid
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->cart = unserialize($order->cart);
        return view('AdminLTE.order.show', ['order' => $order]);
    }

    public function getGrid(Request $request)
    {
        $f = $request->get('f', []);
//        dd($f);
        $id = isset($f['title']) ? $f['title'] : null;
        $first_name = isset($f['first_name']) ? $f['first_name'] : null;
        $last_name = isset($f['last_name']) ? $f['last_name'] : null;
//        dd($last_name);
        $group_by = isset($f['order_by']) ? $f['order_by'] : "created_at";
        $group_dir = isset($f['order_dir']) ? $f['order_dir'] : "DESC";
        $orders = Order::orderBy($group_by, $group_dir);
        if ($id || $first_name || $last_name) {
            $orders->where('id', 'like', '%' . $id . '%')
                    ->where('first_name', 'like', '%' . $first_name .'%')
                    ->where('last_name', 'like', '%' . $last_name .'%');
        }
        $orders = $orders->paginate(10);
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        $grid = new \Datagrid($orders, $f);

        $grid
            ->setColumn('id', 'Номер заказа', [
                'attributes' => ['class' => 'table-text'],
                // Will be sortable column
                'sortable' => true,
                // Will have filter
                'has_filters' => true
            ])

            ->setColumn('first_name', 'Имя', [
                'attributes' => ['class' => 'table-text'],
                // Will be sortable column
                'sortable' => true,
                // Will have filter
                'has_filters' => true
            ])
            ->setColumn('last_name', 'Фамилия', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => true,
                // Wrapper closure will accept two params
                // $value is the actual cell value
                // $row are the all values for this row

            ])
            ->setColumn('created_at', 'Дата заказа', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => false,
                'wrapper' => function ($value, $row) {
                    // The value here is still Carbon instance, so you can format it using the Carbon methods
                    return $value;
                }
            ])
            ->setColumn('address', 'Адрес', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => false,
                'has_filters' => false
            ])
            ->setColumn('telephone', 'Телефон', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => false,
                'has_filters' => false
            ])
            ->setColumn('email', 'Email', [
                'attributes' => ['class' => 'table-text'],
                'sortable' => false,
                'has_filters' => false,
                'wrapper'     => function ($value, $row) {
                    return '<a href="mailto:' . $value . '">' . $value . '</a>';
                }
            ])
            // Setup action column
            ->setActionColumn([
                'attributes' => ['class' => 'text-right'],
                'wrapper' => function ($value, $row) {
                    return '<a style="display: inline-block" href="' . action('Admin\OrderController@show', [$row->id]) . '" class="btn btn-info" title="Просмотр"
                                   data-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>';
                }
            ]);
        return $grid;
    }
}