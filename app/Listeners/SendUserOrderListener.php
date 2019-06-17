<?php

namespace App\Listeners;

use App\Events\OrderAdminEvent;
use App\Mail\OrderUserShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendUserOrderListener
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
     * @param  OrderAdminEvent  $event
     * @return void
     */
    public function handle(OrderAdminEvent $event)
    {

        Mail::to($event->order->email)->send(new OrderUserShipped($event->order));

    }
}
