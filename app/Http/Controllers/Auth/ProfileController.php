<?php

namespace App\Http\Controllers\Auth;

use App\Order;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController
{

    public function getProfile()
    {
//        dd('$user');
        $user = Auth::user();
        $orders = Auth::user()->orders()->latest('created_at')->paginate(10);
//        dd($orders);
//        $orders->transform(function ($order, $key) {
//            $order->cart = json_decode($order->cart);
//            return $order;
//        });

        return view('auth.profile', [
            'user' => $user,
            'orders' => $orders
        ]);
    }
}