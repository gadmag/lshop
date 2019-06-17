<?php

namespace App\Listeners;

use App\Events\OrderCheckoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Product;
use App\Option;
use App\Cart;

class OrderAfterSaveListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCheckoutEvent  $event
     * @return void
     */
    public function handle(OrderCheckoutEvent $event)
    {
        $cart = json_decode($event->order->cart);
        $this->reduceQuantity($cart);
    }

    protected function reduceQuantity($cart)
    {
        foreach ($cart->items as $id => $item)
        {
            $product = Product::findOrFail($item['product_id']);
            $product->quantity -= $item['qty'];
            $product->save();
            if ($item['option_id'])
            {
                $option = Option::findOrFail($item['option_id']);
                $option->quantity -= $item['qty'];
                $option->save();
            }
        }
    }
}
