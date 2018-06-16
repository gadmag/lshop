<?php

namespace App\Http\Controllers\Auth;

use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController
{

    public function getProfile()
    {
        $user = Auth::user();
        $orders = Auth::user()->orders;
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });

        return view('auth.profile', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}