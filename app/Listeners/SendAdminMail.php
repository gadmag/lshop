<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\OrderAdminShipped;
use Illuminate\Support\Facades\Mail;


class SendAdminMail implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries = 3;


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
        Mail::to(config('payment.send_mail'))->send(new OrderAdminShipped($event->order));

    }
}
