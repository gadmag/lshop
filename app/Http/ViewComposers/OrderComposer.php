<?php


namespace App\Http\ViewComposers;

use App\Order;
use Illuminate\View\View;

class OrderComposer
{

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function compose(View $view)
    {
//        dd($this->order->countDefaultStatus()->get());
        return $view->with('countNewOrder', $this->order->countDefaultStatus());
    }
}