<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Product;
use App\Option;
use App\Cart;

class DecreaseQtyOrder
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
     * @param OrderCreateEvent $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        $cart = $event->order->cart;
        $this->decreaseQuantity($cart);
    }

    private function decreaseQuantity($cart)
    {
        foreach ($cart['content'] as $id => $item) {
            $product = Product::findOrFail($item->id);
            $product->quantity -= $item->qty;
            $product->save();
            $this->decreaseQtyOption($item);
        }
    }

    private function decreaseQtyOption($item): void
    {
        if ($item) {
            $option = Option::findOrFail($item->options['id']);
            $option->quantity -= $item->qty;
            $option->save();
        }
    }
}
