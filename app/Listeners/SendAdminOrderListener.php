<?php

namespace App\Listeners;

use App\Events\OrderCheckoutEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\OrderAdminShipped;
use Illuminate\Support\Facades\Mail;

class SendAdminOrderListener
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
        Mail::to(env('ADMIN_MAIL'))->send(new OrderAdminShipped($event->order));

    }
}
