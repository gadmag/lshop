<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::latest('created_at')->paginate(10);
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('AdminLTE.order.index', [
            'orders' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->cart = unserialize($order->cart);
        return view('AdminLTE.order.show', ['order' => $order]);
    }
}