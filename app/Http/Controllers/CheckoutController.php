<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Cart;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderShipped;
use App\WishList;
use App\Product;
use App\Order;
use App\Country;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;


class CheckoutController extends Controller
{


    public function getCheckout()
    {

        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }

        $oldCart = session('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        $countries = Country::with('regions')->active()->get()->keyBy('id');
        return view('shop.checkout', [
            'total' => $total,
            'countries' => collect($countries),

        ]);
    }

    public function postCheckout(CheckoutRequest $request)
    {
//        dd($request->region);
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }

        $oldCart = session('cart');
        $cart = new Cart($oldCart);
//        dd($cart);
        $order = new Order();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->telephone = $request->telephone;
        $order->address = $request->address;
        if ($request->company){
            $order->company = $request->company;
        }
        if ($request->postcode){
            $order->postcode = $request->postcode;
        }
        $order->city = $request->city;
        $order->country = Country::findOrFail($request->country)->name;
        if ($request->region){
            $order->region = Region::findOrFail($request->region)->name;
        }

        $order->payment_method = config("payment.payment_method.$request->payment.method");
        $order->payment_id = config("payment.payment_method.$request->payment.id");
        if($request->comment){
            $order->comment = $request->comment;
        }
        $order->cart = serialize($cart);
        Auth::user()->orders()->save($order);
        Session::forget('cart');
        Mail::to('gadjim4@gmail.com')->send(new OrderShipped($order));
        return redirect()->route('product.index')->with('success', 'Заказ завершен');
    }


}