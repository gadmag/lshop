<?php

namespace App\Observers;

use App\Events\OrderCreateEvent;
use App\Events\OrderUpdateEvent;
use App\Order;
use App\OrderStatus;
use App\ShoppingCart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{


    /**
     * @param Order $order
     * @return void
     */
    public function creating(Order $order)
    {
        $orderStatus = OrderStatus::default()->first();
        $cart = Cart::instance('cart');
        if ($cart->isContent()) {
            $order->cart = $cart->toArray();
            $order->totalPrice = $cart->totalPrice();
        }
        $order->user_id = Auth::user()->id;
        $order->order_status_id = $orderStatus->id;
        $cart->clear();
    }



    /**
     * Handle the order "created" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function created(Order $order)
    {
        event(new OrderCreateEvent($order));
    }



    /**Handle the order "updating" event.
     * @param Order $order
     */
    public function updating(Order $order)
    {
        if (Cart::instance('order')->isContent()) {
            $order->cart = Cart::instance('order')->toArray();
        }
        $cart = $order->cart;
        $payment = $order->payment;
        $cart['shipment']['price'] = (float)request('shipment_price');
        $order->cart = $cart;
        $payment->title = request('payment_title');
        $payment->payment_key = request('payment_key');
        $order->payment = json_encode($payment);
    }

    /**
     * Handle the order "updated" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->is_send) {
            event(new OrderUpdateEvent($order));
        }

    }

    /**
     * Handle the order "deleted" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
