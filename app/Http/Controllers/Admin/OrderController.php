<?php

namespace App\Http\Controllers\Admin;

use App\Shipment;
use App\ShoppingCart\Facades\Cart;
use App\Coupon;
use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\OrderStatus;
use App\Http\Controllers\Controller;
use App\Events\OrderUpdateEvent;


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
        $order->cart = json_decode($order->cart);
        return view('AdminLTE.order.show', ['order' => $order]);
    }


    public function edit($id)
    {
        Cart::instance('order')->destroy();
        $order = Order::findOrFail($id);
        $products = Product::with(['productOptions'])->active()->latest('created_at')->take(5)->get();
        $orderStatus = OrderStatus::all()->pluck('name', 'id');
        $coupons = Coupon::active()->isUses()->betweenDate()->get();
        $payment_config = config('payment');
        return view('AdminLTE.order.edit', [
            'order' => $order,
            'products' => $products,
            'coupons' => $coupons,
            'payment_config' => collect($payment_config),
            'shipments' => Shipment::getShipments(),
            'orderStatus' => $orderStatus
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect("admin/orders")->with([
            'flash_message' => "Заказ №{$order->id} обновлен",
        ]);
    }

    public function create()
    {
        $orderStatus = OrderStatus::all()->pluck('name', 'id');
        return view('AdminLTE.order.create', [
            'orderStatus' => $orderStatus
        ]);
    }

    public function store(Request $request)
    {
        $order = new Order();
        $order->create($request->all());
        return redirect('/admin/orders')->with([
            'flash_message' => "Новый заказ №{$order->id} добавлен",
        ]);
    }

    public function search(Request $request)
    {
        $products = Product::with(['productOptions'])->active()->where('title', 'like', '%' . $request->keywords . '%')
            ->latest('created_at')->take(10)->get();
        return response()->json($products);
    }


    public function destroy(Order $order)
    {
        $order->delete();
        return redirect("admin/orders")->with([
            'flash_message' => "Заказ №'{$order->id}' удален",
        ]);
    }


    public function getGrid(Request $request)
    {
        $f = $request->get('f', []);
        $id = isset($f['id']) ? $f['id'] : null;
        $first_name = isset($f['first_name']) ? $f['first_name'] : null;
        $last_name = isset($f['last_name']) ? $f['last_name'] : null;
        $order_status = isset($f['order_status_id']) ? $f['order_status_id'] : null;
        $group_by = !empty($f['order_by']) ? $f['order_by'] : "created_at";
        $group_dir = isset($f['order_dir']) ? $f['order_dir'] : "DESC";
        $orders = Order::with('status')->orderBy($group_by, $group_dir);
        if ($id) {
            $orders->where('id', '=', $id);
        }

        if ($id || $first_name || $last_name) {
            $orders->where('first_name', 'like', '%' . $first_name . '%')
                ->where('last_name', 'like', '%' . $last_name . '%');
        }
        if ($order_status) {
            $orders->where('order_status_id', '=', $order_status);
        }
//        dd(OrderStatus::all()->pluck('name','id'));
        $orders = $orders->paginate(10);
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
            ->setColumn('order_status_id', 'Статус заказа', [
                'refers_to' => 'status',
                'attributes' => ['class' => 'table-text'],
                'sortable' => true,
                'has_filters' => true,
                'filters' => OrderStatus::all()->pluck('name', 'id'),
                'wrapper' => function ($value, $row) {
                    if ($value) {
                        return '<span class="label label-' . $value->css_class . '">' . $value->name . '</span>';
                    }
                    return '';
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
                'wrapper' => function ($value, $row) {
                    return '<a href="mailto:' . $value . '">' . $value . '</a>';
                }
            ])
            // Setup action column
            ->setActionColumn([
                'attributes' => ['class' => 'text-right'],
                'wrapper' => function ($value, $row) {
                    return '
                    <a class="btn btn-primary" href="' . action('Admin\OrderController@edit', [$row->id]) . '" title="Редактировать" data-toggle="tooltip">
                     <i class="fa fa-edit"></i>
                    </a>
                  
                    <a style="display: inline-block" href="' . action('Admin\OrderController@show', [$row->id]) . '" class="btn btn-info" title="Просмотр"
                                   data-toggle="tooltip">
                                    <i class="fa fa-eye"></i>
                                </a>
                    <form style="display: inline-block" action="' . action('Admin\OrderController@destroy', [$row->id]) . '" method="POST">
                                    ' . csrf_field() . ' ' . method_field('DELETE') . '
                                    <button style="display: inline-block" type="submit" onclick="return confirm(\'Вы уверены?\')" class="btn btn-danger" data-toggle="tooltip" title="Удалить">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>';
                }
            ]);
        return $grid;
    }
}