<?php

namespace App\Http\Controllers;

use App\Event;
use App\Events\OrderCheckoutEvent;
use Illuminate\Support\Facades\Redirect;
use App\Catalog;
use App\Cart;
use App\Coupon;
use App\Http\Requests\CheckoutRequest;
use App\Option;
use App\Product;
use App\Order;
use App\Country;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        if ($cart->totalPrice < config('payment.cart_setting.min_sum')){
             return redirect('/shopping-cart');
        }
        $total = $cart->totalPrice;
        $countries = Country::with('regions')->active()->get()->keyBy('id');
        $coupons = Coupon::active()->isQty()->betweenDate()->get();
        $payment_config = config('payment');
        return view('shop.checkout', [
            'total' => $total,
            'countries' => collect($countries),
            'coupons' => $coupons,
            'payment_config' => collect($payment_config),

        ]);
    }

    public function postCheckout(CheckoutRequest $request)
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }

        $oldCart = session('cart');
        $cart = new Cart($oldCart);
        $order = new Order();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->telephone = $request->telephone;
        $order->address = $request->address;
        $order->totalPrice = $cart->totalPrice;
        if ($request->company){
            $order->company = $request->company;
        }
        if ($request->postcode){
            $order->postcode = $request->postcode;
        }

        $order->city = $request->city;
        if ($request->country){
            $order->country = Country::findOrFail($request->country)->name;
        }
        if ($request->region){
            $order->region = Region::findOrFail($request->region)->name;
        }

        if ($request->shipment){
            $shipment_conf = config("payment.shipment_method.$request->shipment");
            $order->shipment_price = ($order->totalPrice >= config('payment.cart_setting.free_shipping'))? 0 : $this->getShipmentPrice($shipment_conf, $cart->totalWeight);
            $order->totalPrice +=$order->shipment_price;
            $order->shipment_method = $shipment_conf['method'];
        }

        if ($request->coupon){
            $coupon = Coupon::active()->isQty()->betweenDate()->where('code', $request->coupon)->first();
            if ($coupon){
                $coupon->uses_total = $coupon->uses_total - 1;
                $coupon->save();
                $order->cart->coupon = $coupon;
                $order->coupon = $coupon->code;
                $order->totalPrice = $order->totalPrice - $order->totalPrice*$coupon->discount/100;
            }
        }

        $order->payment_method = config("payment.payment_method.$request->payment.method");
        $order->payment_id = config("payment.payment_method.$request->payment.id");
        if($request->comment){
            $order->comment = $request->comment;
        }
        $order->cart = json_encode($cart);
        Auth::user()->orders()->save($order);
        event(new OrderCheckoutEvent($order));
        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Ваш заказ принят. Данные для оплаты будут отправленны на Вашу почту.');
    }


    protected function getShipmentPrice($params, $weight)
    {
        foreach ($params as $key => $price){
            if ($weight <= $key){
                return $price;
            }
        }
    }
}