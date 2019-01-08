<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
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
     * @param  OrderCreateEvent  $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        $cart = unserialize($event->order->cart);
        $this->reduceQuantity($cart);
    }

    protected function reduceQuantity(Cart $cart)
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
