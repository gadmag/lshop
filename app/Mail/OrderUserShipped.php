<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUserShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//       $cart =  json_decode($this->order->cart);
//       dd($cart->items[0]->frontImg->filename);
        return $this->view('emails.order.shipped',[
            'order' => $this->order,
            'cart' => json_decode($this->order->cart)
        ])->subject('Новый заказ');
    }
}
