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
        $orders = Auth::user()->orders()->latest('created_at')->paginate(10);
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