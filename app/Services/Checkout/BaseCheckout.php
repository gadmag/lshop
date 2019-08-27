<?php


namespace App\Services\Checkout;


use App\Order;

interface BaseCheckout
{
    public function get():array;
    public function store(array  $data): Order;
}