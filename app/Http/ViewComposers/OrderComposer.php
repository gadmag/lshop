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
        return $view->with('countNewOrder', $this->order->getCountDefaultStatus());
    }
}